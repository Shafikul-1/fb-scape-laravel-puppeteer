import puppeteer from 'puppeteer';
import fs from 'fs';

let browser;
let data = [];


const contactPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/'; // next div loop

async function fbDetails(links) {
    try {
        // browser = await puppeteer.launch();
        browser = await puppeteer.launch({
            headless: false,
            args: ['--start-maximized'],
        });


        for (const link of links) {
            const page = await browser.newPage();
            let url = '';

            // Check Valied Link
            if (!url.includes('https://') && !url.includes('http://')) {
                url = link;
            } else {
                console.error('Invalid username type.');
                await page.close();
                continue;
            }

            const currentPageAllData = {};

            try {
                await page.goto(url, { waitUntil: 'networkidle0', timeout: 40000 });
                // if scroll page then use
                // await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));

                // remove popup
                await page.keyboard.press('Escape');

                // Post Data Collect
                const postDetails = await page.evaluate(() => {
                    const data = {};
                    // Post Thake Name collect
                    const namePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[2]/div/div[1]/div/div/div/div/div/div/div/div/div/div/div[13]/div/div/div[2]/div/div[2]/div/div[1]';
                    const nameElement = document.evaluate(
                        namePath,
                        document,
                        null,
                        XPathResult.FIRST_ORDERED_NODE_TYPE,
                        null
                    ).singleNodeValue;
                    const nameText = nameElement.innerText.trim();

                    // Post Thake Time Collect
                    const timePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[2]/div/div[1]/div/div/div/div/div/div/div/div/div/div/div[13]/div/div/div[2]/div/div[2]/div/div[2]';
                    const timeElement = document.evaluate(
                        timePath,
                        document,
                        null,
                        XPathResult.FIRST_ORDERED_NODE_TYPE,
                        null
                    ).singleNodeValue;
                    const timeText = timeElement.innerText.trim().replace(/\s+/g, ' ');

                    // Send Data post array
                    return data['postDetails'] = { name: nameText , timeText: timeText };
                });
                currentPageAllData['postDetails'] = postDetails;
            } catch (error) {
                console.error(`An Error Ocurred for ${url} : `, error.message);
                data.push({ url, error: error.message });
            }
            await page.close();

            data.push(currentPageAllData);
        }
    } catch (error) {
        console.error('Error occurred:', error);
    } finally {
        if (browser) {
            await browser.close();
        }

        // console.log(JSON.stringify(data));
        fs.writeFile('output.json', JSON.stringify(data, null, 2), (err) => {
            if (err) {
                console.error('Error writing file:', err);
            } else {
                console.log(`File output.json has been saved.`);
            }
        });
    }
}

fbDetails([
    'https://www.facebook.com/TroyMichaelPhotgraphy',
    'https://www.facebook.com/profile.php?id=61552158826567'
]);


