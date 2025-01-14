const express = require('express');
const cors = require('cors');
const { scrapeReviews } = require('./scrape_reviews'); // Import the scraping function

const app = express();
const port = 3000;

// Allow all origins (adjust this if you want to restrict access to specific domains)
app.use(cors());

// Middleware to parse JSON body
app.use(express.json());

// Endpoint to trigger review scraping
app.post('/scrape-reviews', async (req, res) => {
    const { url } = req.body;
    
    if (!url) {
        return res.status(400).json({ success: false, message: 'URL is required.' });
    }

    try {
        const result = await scrapeReviews(url);
        if (result.success) {
            res.status(200).json(result);
        } else {
            res.status(500).json(result);
        }
    } catch (error) {
        res.status(500).json({ success: false, message: 'An error occurred.' });
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
