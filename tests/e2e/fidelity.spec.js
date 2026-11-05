import { test, expect } from '@playwright/test';

const originalUrl = 'http://127.0.0.1:8001/index.html';
const laravelUrl = 'http://127.0.0.1:8000';
const views = [
    ['beranda', '/'],
    ['alat', '/alat'],
    ['langkah', '/langkah'],
    ['alur-sinyal', '/alur-sinyal'],
    ['ptz', '/ptz'],
    ['hari-h', '/hari-h'],
    ['latihan', '/latihan'],
    ['bantuan', '/bantuan'],
];
const widths = [390, 768, 1440];

async function openPair(browser, width, view, route) {
    const original = await browser.newPage({ viewport: { width, height: 900 } });
    const laravel = await browser.newPage({ viewport: { width, height: 900 } });

    await Promise.all([
        original.goto(`${originalUrl}#${view}`, { waitUntil: 'domcontentloaded' }),
        laravel.goto(`${laravelUrl}${route}`, { waitUntil: 'domcontentloaded' }),
    ]);
    await Promise.all([original.waitForTimeout(100), laravel.waitForTimeout(100)]);

    return { original, laravel };
}

async function readViewState(page) {
    return page.evaluate(() => ({
        visibleViews: [...document.querySelectorAll('.app-view.active-view')].map((el) => el.id),
        activeDesktop: [...document.querySelectorAll('.nav-pill.active')].map((el) => el.dataset.nav),
        activeMobile: [...document.querySelectorAll('.mobile-nav-pill.text-primary')].map((el) => el.dataset.nav),
        hash: window.location.hash,
        title: document.title,
    }));
}

async function runAction(page, action) {
    await page.evaluate(action);
    await page.waitForTimeout(50);
    return page.evaluate(() => ({
        visibleViews: [...document.querySelectorAll('.app-view.active-view')].map((el) => el.id),
        activeDesktop: [...document.querySelectorAll('.nav-pill.active')].map((el) => el.dataset.nav),
        searchModal: document.getElementById('search-modal')?.className,
        hotlineModal: document.getElementById('hotline-modal')?.className,
        atemModal: document.getElementById('atem-modal')?.className,
        certModal: document.getElementById('cert-modal')?.className,
        step: document.getElementById('step-number-badge')?.textContent,
        route: document.querySelector('.route-card.active, [data-rute].bg-primary')?.dataset.rute ?? null,
        ptzOverlay: document.getElementById('ptz-status-overlay')?.textContent,
        cableInstruction: document.getElementById('cable-instruction-text')?.textContent,
        helpVisible: [...document.querySelectorAll('.help-card:not(.hidden)')].length,
        quiz: document.getElementById('quiz-question-number')?.textContent,
    }));
}

test.describe('fidelity visual dan interaksi', () => {
    test('membandingkan view aktif dan screenshot pada tiga lebar', async ({ browser }) => {
        test.setTimeout(180000);

        for (const [view, route] of views) {
            for (const width of widths) {
                const { original, laravel } = await openPair(browser, width, view, route);
                const originalState = await readViewState(original);
                const laravelState = await readViewState(laravel);

                expect(laravelState.visibleViews).toEqual(originalState.visibleViews);
                expect(laravelState.activeDesktop).toEqual(originalState.activeDesktop);
                expect(laravelState.activeMobile).toEqual(originalState.activeMobile);

                await original.screenshot({ path: `docs/visual-diff/asli-${view}-${width}.png`, fullPage: true });
                await laravel.screenshot({ path: `docs/visual-diff/laravel-${view}-${width}.png`, fullPage: true });
                await original.close();
                await laravel.close();
            }
        }
    });

    test('membandingkan aksi interaktif utama', async ({ browser }) => {
        test.setTimeout(120000);
        const { original, laravel } = await openPair(browser, 1440, 'beranda', '/');
        const actions = [
            'document.querySelector(\'a[data-nav="alat"]\').click()',
            'openSearchModal()',
            'closeSearchModal()',
            'openHotlineModal()',
            'closeHotlineModal()',
            'switchView("langkah"); selectStep(12); nextStep(); prevStep()',
            'switchView("alat"); filterAlat("audio", document.querySelector("#alat-filter-group button:nth-child(2)"))',
            'switchView("alur-sinyal"); selectRute("mic-mixer"); resetRutePilihan()',
            'switchView("ptz"); ptzMove("up"); ptzZoom("in"); applyPtzPreset(2); ptzReset()',
            'switchView("hari-h"); document.querySelector(".hari-h-box").click(); updateHariHCount(); resetHariHChecklist()',
            'switchView("latihan"); pickCable("35"); plugCableIntoPort("atem-mic1"); openAtemPortInspector(); inspectPort("mic1"); closeAtemModal()',
            'gotoQuiz(3); answerQuiz("A"); nextQuiz(); prevQuiz()',
            'switchView("bantuan"); filterHelpTag("video"); resetHelpFilter()',
            'openCertificateModal(); closeCertModal()',
        ];

        for (const action of actions) {
            const originalState = await runAction(original, action);
            const laravelState = await runAction(laravel, action);
            expect(laravelState).toEqual(originalState);
        }

        await original.close();
        await laravel.close();
    });

    test('memastikan navigasi keyboard, refresh, logo, dan console bersih', async ({ browser }) => {
        test.setTimeout(120000);
        const failures = [];
        const pages = [];

        for (const [label, url] of [
            ['asli', `${originalUrl}#beranda`],
            ['laravel', laravelUrl],
        ]) {
            const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });
            page.on('console', (message) => {
                if (message.type() === 'error') failures.push(`${label} console: ${message.text()}`);
            });
            page.on('response', (response) => {
                if (label === 'laravel' && response.status() >= 400) {
                    failures.push(`${label} HTTP ${response.status()}: ${response.url()}`);
                }
            });
            pages.push(page);
            await page.goto(url, { waitUntil: 'domcontentloaded' });
            await page.waitForTimeout(100);
            await page.keyboard.press('/');
            await expect(page.locator('#search-modal')).toHaveClass(/flex/);
            await page.keyboard.press('Escape');
            await expect(page.locator('#search-modal')).toHaveClass(/hidden/);
            await page.locator('.nav-pill[data-nav="alat"]').click();
            await expect(page.locator('.app-view.active-view')).toHaveAttribute('id', 'view-alat');
            await page.goBack();
            await page.goForward();
            await page.reload({ waitUntil: 'domcontentloaded' });
            await page.waitForTimeout(100);
            await expect(page.locator('.app-view.active-view')).toHaveAttribute('id', 'view-alat');
            if (label === 'laravel') {
                await expect(page.locator('img[alt="Logo Komsos"]')).toHaveAttribute('src', /logo-komsos\.png/);
            }
        }

        expect(failures).toEqual([]);
        await Promise.all(pages.map((page) => page.close()));
    });
});
