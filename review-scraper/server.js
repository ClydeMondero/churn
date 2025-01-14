const express = require('express');
const puppeteer = require('puppeteer');

const app = express();
const PORT = 3000;

app.use(express.static('public')); // Serve static files from 'public' folder

async function scrapeReviews(url) {
    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();
    await page.goto(url, { waitUntil: 'networkidle2' });

    const reviews = await page.evaluate(() => {
        const reviewElements = document.querySelectorAll('.review-title');
        const ratingElements = document.querySelectorAll('.review-rate .review-star');

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

app.get('/scrape-reviews', async (req, res) => {
    const url = 'https://www.bankquality.com/institution/2730/bdo-philippines/';
    const reviews = await scrapeReviews(url);
    res.json(reviews);
});

app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
