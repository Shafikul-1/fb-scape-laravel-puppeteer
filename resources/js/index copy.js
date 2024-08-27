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

        // check Url String
        function checkProfileId(url) {
            const pattern = /profile\.php\?id=\d+/;
            return pattern.test(url);
        }

        for (const link of links) {
            const page = await browser.newPage();
            let url = '';
            let profileIdUrl = null;
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
                if (checkProfileId(url)) {
                    profileIdUrl = page.url();
                }

                // if scroll page then use
                // await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));

                // remove popup
                await page.keyboard.press('Escape');

                // Post Data Collect
                const postDetails = await page.evaluate(() => {

                    const data = {};
                    function textGet(contentPath) {
                        const elementText = document.evaluate(
                            contentPath,
                            document,
                            null,
                            XPathResult.FIRST_ORDERED_NODE_TYPE,
                            null
                        ).singleNodeValue;
                        return elementText.innerText.trim();
                    }

                    // Post Thake Name collect
                    const namePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[2]/div/div[1]/div/div/div/div/div/div/div/div/div/div/div[13]/div/div/div[2]/div/div[2]/div/div[1]';
                    const nameText = textGet(namePath);

                    // Post Thake Time Collect
                    const timePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div[2]/div/div[2]/div/div[1]/div/div/div/div/div/div/div/div/div/div/div[13]/div/div/div[2]/div/div[2]/div/div[2]';
                    const timeText = textGet(timePath).replace(/\s+/g, ' ');

                    // Send Data post array
                    return data['postDetails'] = { name: nameText, timeText: timeText };
                });
                currentPageAllData['postDetails'] = postDetails;
            } catch (error) {
                console.error(`An Error Ocurred for ${url} : `, error.message);
                data.push({ url, error: error.message });
            }
            await page.close();



            // New Page Contact Details
            const newPage = await browser.newPage();
            let newUrl = '';
            if (checkProfileId(link)) {
                if (profileIdUrl != null) {
                    newUrl = `${profileIdUrl}?sk=about`;
                } else {
                    await newPage.close();
                }
            } else {
                newUrl = `${link}/about_contact_and_basic_info`;
            }

            try {
                await newPage.goto(newUrl, { waitUntil: 'networkidle0', timeout: 60000 });
                // await newPage.click('body');
                // await page.mouse.click(100, 200);
                // await newPage.keyboard.press('Escape');
                const contactDetails = await newPage.evaluate(() => {

                    const data = {};
                    function textGet(contentPath) {
                        const elementText = document.evaluate(
                            contentPath,
                            document,
                            null,
                            XPathResult.FIRST_ORDERED_NODE_TYPE,
                            null
                        ).singleNodeValue;
                        return elementText ? elementText.innerText.trim() : 'Not found';
                    }

                    function divCount(countPath) {
                        const nodesSnapShot = document.evaluate(countPath, document, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                        return nodesSnapShot.snapshotLength;
                    }


                    let detailsData = {};

                    // const contactDetailsMailPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div';
                    // for (let mainPath = 0; mainPath < divCount(contactDetailsMailPath); mainPath++) {
                    //     let contactDetailsMailPathNext = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div';

                    //     for (let contactMain = 0; contactMain < divCount(`${contactDetailsMailPathNext}/div[${mainPath}]/div/div`); contactMain++) {

                    //         console.log(contactDetailsMailPathNext);
                    //         let detailsBasePath = `${contactDetailsMailPathNext}/div[${mainPath}]/div/`;
                    //         // if (contactMain == 0) {
                    //         //     continue;
                    //         // }
                    //         // if (contactMain == 1) {
                    //         //     const contactValuePath = `${detailsBasePath}div[${i}]`;
                    //         //     const contactValue = textGet(contactValuePath);
                    //         //     detailsData['category'] = contactValue;
                    //         // }
                    //         console.log(detailsBasePath);

                    //     }
                    // }

                    const contactDetailsPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div[2]/div/div';
                    for (let i = 0; i <= divCount(contactDetailsPath); i++) {
                        let detailsBasePath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div[2]/div/';
                        if(i == 0){
                            continue;
                        }
                        if(i == 1){
                            const contactValuePath = `${detailsBasePath}div[${i}]`;
                            const contactValue = textGet(contactValuePath);
                            detailsData['category'] = contactValue;
                        }
                        if(i == 2){
                            const contactValuePath = `${detailsBasePath}div[${i}]/div/div/div[2]/div[2]/div[1]`;
                            const contactKeyPath = `${detailsBasePath}div[${i}]/div/div/div[2]/div[2]/div[2]`;
                            const contactKey = textGet(contactKeyPath);
                            const contactValue = textGet(contactValuePath);
                            detailsData[contactKey] = contactValue;
                        }
                        const contactValuePath = `${detailsBasePath}div[${i}]/div/div/div[2]/ul/li/div/div/div[2]`;
                        const contactKey = textGet(contactValuePath);

                        const contactKeyPath = `${detailsBasePath}div[${i}]/div/div/div[2]/ul/li/div/div/div[1]`;
                        const contactValue = textGet(contactKeyPath);
                        detailsData[contactKey] = contactValue;

                    }

                    const socialMediaPath = '/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div/div/div';
                    for (let index = 0; index < divCount(socialMediaPath); index++) {
                       let SocialMainPath ='/html/body/div[1]/div/div[1]/div/div[3]/div/div/div[1]/div[1]/div/div/div[4]/div/div/div/div[1]/div/div/div/div/div[2]/div/div/div/div/div/';
                       const socialValuePath = `${SocialMainPath}div[${index}]/div/div/div[2]/ul/li/div/div/div[1]`;
                       const socialKeyPath = `${SocialMainPath}div[${index}]/div/div/div[2]/ul/li/div/div/div[2]`;
                       const spcialKey = textGet(socialKeyPath);
                       const spcialValue = textGet(socialValuePath);
                       detailsData[spcialKey] = spcialValue;
                    }


                    return data['contactDetails'] = detailsData;



                });
                currentPageAllData['contactDetails'] = contactDetails;


            } catch (error) {
                console.error(`An Error Ocurred for Contact Details ${newUrl} : `, error.message);
                data.push({ newUrl, error: error.message });
            }
            await newPage.close();


            data.push(currentPageAllData);

        }
    } catch (error) {
        console.error('Error occurred:', error);
    } finally {
        if (browser) {
            await browser.close();
        }
        console.log(JSON.stringify(data));

        // fs.writeFile('output.json', JSON.stringify(data, null, 2), (err) => {
        //     if (err) {
        //         console.error('Error writing file:', err);
        //     } else {
        //         //console.log(`File output.json has been saved.`);
        //         console.log(JSON.stringify(data));
        //     }
        // });
    }
}

// fbDetails([
//     'https://www.facebook.com/TroyMichaelPhotgraphy',
//     'https://www.facebook.com/profile.php?id=61552158826567'
// ]);
const encodedUsernames = process.argv[2];
let urlArray = JSON.parse(encodedUsernames);
fbDetails(urlArray);
