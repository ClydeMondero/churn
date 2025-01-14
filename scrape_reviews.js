const puppeteer = require("puppeteer");
const mysql = require("mysql2/promise");
const fs = require("fs");

async function createDatabaseConnection() {
  const connection = await mysql.createConnection({
    host: "193.203.184.155",
    user: "u816730822_thesis",
    password: "Churn@123",
    database: "u816730822_thesis",
    port: 3306,
  });
  return connection;
}

async function insertReviews(connection, reviews, placeName) {
  try {
    const [deleteResult] = await connection.execute("DELETE FROM reviews");
    console.log(
      `Deleted ${deleteResult.affectedRows} rows from reviews table.`
    );

    for (const review of reviews) {
      const { reviewerName, reviewText, rating } = review;
      try {
        const [insertResults] = await connection.execute(
          "INSERT INTO reviews (reviewer_name, review_text, rating, place_name) VALUES (?, ?, ?, ?)",
          [reviewerName, reviewText, rating, placeName]
        );
        console.log(`Review inserted with ID: ${insertResults.insertId}`);
        await connection.execute(
          "INSERT INTO reviews_history (reviewer_name, review_text, rating, action, timestamp, place_name) VALUES (?, ?, ?, ?, ?, ?)",
          [reviewerName, reviewText, rating, "insert", new Date(), placeName]
        );
      } catch (err) {
        console.error("Error inserting review:", err);
      }
    }
  } catch (err) {
    console.error("Error deleting existing reviews:", err);
  }
}

async function scrapeReviews(url) {
  let connection;
  try {
    connection = await createDatabaseConnection();

    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();

    await page.setViewport({ width: 1280, height: 800 });
    await page.goto(url, { waitUntil: "networkidle0", timeout: 0 });

    // Waiting for an alternate selector
    await page.waitForSelector("h1", { timeout: 60000 });

    const placeName = await page.evaluate(() => {
      const placeElement = document.querySelector("h1");
      return placeElement ? placeElement.innerText.trim() : "Unknown Place";
    });

    if (placeName === "Unknown Place") {
      console.log("Place name not found.");
    } else {
      console.log("Place Name:", placeName);
    }

    // Scroll the page to load all reviews
    await page.evaluate(async () => {
      const distance = 100;
      const delay = 300;
      let totalHeight = 0;
      while (true) {
        window.scrollBy(0, distance);
        await new Promise((resolve) => setTimeout(resolve, delay));
        const newHeight = document.body.scrollHeight;
        if (newHeight === totalHeight) break;
        totalHeight = newHeight;
      }
    });

    await page.waitForSelector(".jftiEf", { timeout: 60000 });

    const reviews = await page.evaluate(() => {
      const reviews = [];
      const reviewElements = document.querySelectorAll(".jftiEf");
      reviewElements.forEach((reviewElement) => {
        const reviewerName = reviewElement.querySelector(".d4r55")
          ? reviewElement.querySelector(".d4r55").innerText
          : "No name";
        const reviewText = reviewElement.querySelector(".wiI7pd")
          ? reviewElement.querySelector(".wiI7pd").innerText
          : "No review text";
        const ratingElement = reviewElement.querySelector(".kvMYJc");
        let rating = 0;
        if (ratingElement && ratingElement.getAttribute("aria-label")) {
          const ratingText = ratingElement.getAttribute("aria-label");
          rating = parseFloat(ratingText.split(" ")[0]);
        }
        reviews.push({ reviewerName, reviewText, rating });
      });
      return reviews;
    });

    console.log("Total reviews scraped:", reviews.length);

    await insertReviews(connection, reviews, placeName);

    fs.writeFileSync("reviews.json", JSON.stringify(reviews, null, 2));

    await browser.close();
    return {
      success: true,
      message: "All reviews scraped and saved successfully.",
    };
  } catch (error) {
    console.error("Error during scraping:", error);
    return {
      success: false,
      message: "Error occurred while scraping reviews.",
    };
  } finally {
    if (connection) {
      await connection.end();
    }
  }
}

module.exports = { scrapeReviews };
