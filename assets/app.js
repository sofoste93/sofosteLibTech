(() => {
    'use strict';

    const translations = JSON.parse(document.querySelector('#translations').textContent);
    const cards = [...document.querySelectorAll('.resource-card')];
    const search = document.querySelector('input[name="q"]');
    const tabs = [...document.querySelectorAll('[data-category]')];
    const languageSelect = document.querySelector('#language-select');
    const resultCount = document.querySelector('#result-count');
    const resultLabel = document.querySelector('#result-label');
    const emptyState = document.querySelector('#empty-state');
    let activeCategory = document.querySelector('.category-tab.active')?.dataset.category || 'all';
    let language = document.documentElement.lang;

    const readJson = (key, fallback) => {
        try { return JSON.parse(localStorage.getItem(key)) ?? fallback; } catch (_) { return fallback; }
    };
    let savedResources = new Set(readJson('libtech-saved', []));

    // The form works without JavaScript; enhancement below makes filtering instant.
    document.querySelector('#library-filters').addEventListener('submit', (event) => event.preventDefault());

    function filterResources() {
        const needle = search.value.trim().toLocaleLowerCase();
        let visible = 0;
        cards.forEach((card) => {
            const categoryMatches = activeCategory === 'all' || card.dataset.category === activeCategory;
            const searchMatches = !needle || card.dataset.search.toLocaleLowerCase().includes(needle);
            card.hidden = !(categoryMatches && searchMatches);
            if (!card.hidden) visible += 1;
        });
        resultCount.textContent = visible;
        resultLabel.textContent = translations[language][visible === 1 ? 'result' : 'results'];
        emptyState.hidden = visible !== 0;
    }

    search.addEventListener('input', filterResources);
    tabs.forEach((tab) => tab.addEventListener('click', () => {
        activeCategory = tab.dataset.category;
        tabs.forEach((item) => item.classList.toggle('active', item === tab));
        filterResources();
    }));
    document.querySelector('#clear-filters').addEventListener('click', () => {
        search.value = '';
        activeCategory = 'all';
        tabs.forEach((tab) => tab.classList.toggle('active', tab.dataset.category === 'all'));
        filterResources();
        search.focus();
    });

    function updateSaveButtons() {
        document.querySelectorAll('[data-save]').forEach((button) => {
            const isSaved = savedResources.has(button.dataset.save);
            button.setAttribute('aria-pressed', String(isSaved));
            button.children[0].textContent = isSaved ? '◆' : '◇';
            button.children[1].textContent = translations[language][isSaved ? 'saved' : 'save'];
            button.children[1].dataset.i18n = isSaved ? 'saved' : 'save';
        });
    }
    document.querySelectorAll('[data-save]').forEach((button) => button.addEventListener('click', () => {
        savedResources.has(button.dataset.save) ? savedResources.delete(button.dataset.save) : savedResources.add(button.dataset.save);
        localStorage.setItem('libtech-saved', JSON.stringify([...savedResources]));
        updateSaveButtons();
    }));

    function applyLanguage(nextLanguage) {
        language = translations[nextLanguage] ? nextLanguage : 'en';
        document.documentElement.lang = language;
        languageSelect.value = language;
        document.querySelector('#language-input').value = language;
        document.querySelectorAll('[data-i18n]').forEach((element) => {
            const value = translations[language][element.dataset.i18n];
            if (value) element.textContent = value;
        });
        document.querySelectorAll('[data-i18n-placeholder]').forEach((element) => {
            element.placeholder = translations[language][element.dataset.i18nPlaceholder];
        });
        localStorage.setItem('libtech-language', language);
        updateSaveButtons();
        filterResources();
    }
    languageSelect.addEventListener('change', () => applyLanguage(languageSelect.value));

    document.querySelectorAll('[data-open-dialog]').forEach((button) => button.addEventListener('click', () => {
        document.querySelector(`#${button.dataset.openDialog}`).showModal();
    }));
    document.querySelectorAll('dialog').forEach((dialog) => dialog.addEventListener('click', (event) => {
        if (event.target === dialog) dialog.close();
    }));

    const themeButtons = [...document.querySelectorAll('[data-theme-choice]')];
    function applyTheme(theme) {
        const selected = ['light', 'dark', 'system'].includes(theme) ? theme : 'system';
        document.documentElement.dataset.theme = selected;
        localStorage.setItem('libtech-theme', selected);
        themeButtons.forEach((button) => button.classList.toggle('active', button.dataset.themeChoice === selected));
    }
    themeButtons.forEach((button) => button.addEventListener('click', () => applyTheme(button.dataset.themeChoice)));

    const motionToggle = document.querySelector('#reduce-motion');
    function applyMotion(reduce) {
        document.documentElement.classList.toggle('reduce-motion', reduce);
        motionToggle.checked = reduce;
        localStorage.setItem('libtech-reduce-motion', String(reduce));
    }
    motionToggle.addEventListener('change', () => applyMotion(motionToggle.checked));

    applyTheme(localStorage.getItem('libtech-theme') || 'system');
    applyMotion(localStorage.getItem('libtech-reduce-motion') === 'true');
    applyLanguage(localStorage.getItem('libtech-language') || language);

    if ('serviceWorker' in navigator && location.protocol !== 'file:') {
        window.addEventListener('load', () => navigator.serviceWorker.register('service-worker.js').catch(() => {}));
    }
})();

