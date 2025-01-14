const puppeteer = require('puppeteer');

async function scrapeReviews(url) {
    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();
    await page.goto(url, { waitUntil: 'networkidle2' });

    const reviews = await page.evaluate(() => {
        const reviewElements = document.querySelectorAll('.review-title');
        const ratingElements = document.querySelectorAll('.review-rate');

        const reviewData = [];
        reviewElements.forEach((element, index) => {
            const title = element.innerText;
            const rating = ratingElements[index] ? ratingElements[index].innerText : 'No Rating';
            reviewData.push({ title, rating });
        });
        return reviewData;
    });

    await browser.close();
    return reviews;
}

async function displayReviews() {
    const url = 'https://www.bankquality.com/institution/2730/bdo-philippines/';
    const reviews = await scrapeReviews(url);

    console.log(reviews);  // Log the scraped reviews

    const reviewsContainer = document.getElementById('reviews-container');

    if (reviews.length > 0) {
        reviews.forEach(review => {
            const reviewDiv = document.createElement('div');
            reviewDiv.className = 'review';
            reviewDiv.innerHTML = `<strong>Title:</strong> ${review.title}<br><strong>Rating:</strong> ${review.rating}`;
            reviewsContainer.appendChild(reviewDiv);
        });
    } else {
        reviewsContainer.innerHTML = 'No reviews found.';
    }
}


// Run the display function
displayReviews();
