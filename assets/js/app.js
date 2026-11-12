/* RusStart front-end behaviour. No libraries. */
(function () {
    'use strict';

    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
    const el = (tag, attrs = {}, text) => {
        const node = document.createElement(tag);
        Object.entries(attrs).forEach(([k, v]) => node.setAttribute(k, v));
        if (text !== undefined) node.textContent = text;
        return node;
    };
    let uid = 0;

    /* ---------- header ---------- */

    const header = $('[data-header]');
    if (header) {
        const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 12);
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });

        const toggle = $('[data-nav-toggle]');
        const nav = $('[data-nav]');
        if (toggle && nav) {
            toggle.addEventListener('click', () => {
                const open = nav.classList.toggle('open');
                header.classList.toggle('nav-open', open);
                toggle.setAttribute('aria-expanded', String(open));
            });
        }
    }

    /* ---------- account menu ---------- */

    $$('[data-menu]').forEach((menu) => {
        const btn = $('[data-menu-btn]', menu);
        const set = (open) => {
            menu.classList.toggle('open', open);
            btn.setAttribute('aria-expanded', String(open));
        };
        btn.addEventListener('click', () => set(!menu.classList.contains('open')));
        document.addEventListener('click', (e) => { if (!menu.contains(e.target)) set(false); });
        menu.addEventListener('keydown', (e) => { if (e.key === 'Escape') { set(false); btn.focus(); } });
    });

    /* ---------- slow reveal on scroll ---------- */

    const revealItems = $$('[data-reveal]');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
            // items that enter together slide in one after another
            entries.filter((en) => en.isIntersecting).forEach((en, i) => {
                en.target.style.setProperty('--d', `${Math.min(i, 6) * 110}ms`);
                en.target.classList.add('in');
                io.unobserve(en.target);
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });
        revealItems.forEach((item) => io.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add('in'));
    }

    /* ---------- custom dropdown ---------- */

    function enhanceSelect(wrap) {
        const select = $('select', wrap);
        if (!select) return;
        const id = `sel-${++uid}`;
        const options = Array.from(select.options);
        const otherBox = document.querySelector(`[data-other-for="${select.id}"]`);

        const btn = el('button', { type: 'button', class: 'select-btn', 'aria-haspopup': 'listbox', 'aria-expanded': 'false', 'aria-controls': id });
        const label = el('span', { class: 'select-label' }, wrap.dataset.label || '');
        const value = el('span', { class: 'select-value' });
        btn.append(label, value);

        const panel = el('div', { class: 'select-panel' });
        const realOptions = options.filter((o) => o.value !== '' || o.textContent.trim() !== '');
        let search = null;
        if (realOptions.length > 8) {
            search = el('input', { type: 'text', class: 'select-search', placeholder: 'Type to filter', 'aria-label': `Filter ${wrap.dataset.label || 'options'}`, autocomplete: 'off' });
            panel.append(search);
        }
        const list = el('ul', { class: 'select-list', role: 'listbox', id, tabindex: '-1' });
        const empty = el('p', { class: 'select-empty', hidden: '' }, 'Nothing matches. Choose "Other" to add it.');
        panel.append(list, empty);

        const items = realOptions.map((opt, i) => {
            const li = el('li', { role: 'option', id: `${id}-${i}`, 'data-value': opt.value }, opt.textContent);
            if (opt.hasAttribute('data-other')) li.classList.add('is-other');
            list.append(li);
            return li;
        });

        wrap.append(btn, panel);
        wrap.classList.add('ready');
        select.tabIndex = -1;
        select.setAttribute('aria-hidden', 'true');

        let active = -1;
        const visible = () => items.filter((li) => !li.hidden);

        function sync() {
            const opt = select.options[select.selectedIndex];
            const has = !!opt && (opt.value !== '' || opt.textContent.trim() !== '');
            value.textContent = has ? opt.textContent : '';
            wrap.classList.toggle('has-value', has);
            items.forEach((li) => li.setAttribute('aria-selected', String(has && li.dataset.value === opt.value)));
            btn.setAttribute('aria-label', `${wrap.dataset.label || ''}: ${has ? opt.textContent : 'not chosen'}`);
            if (otherBox) {
                const show = select.value === '__other';
                otherBox.hidden = !show;
                const input = $('input', otherBox);
                input.disabled = !show;
            }
        }

        function setActive(li) {
            items.forEach((x) => x.classList.remove('active'));
            active = li ? items.indexOf(li) : -1;
            if (li) {
                li.classList.add('active');
                li.scrollIntoView({ block: 'nearest' });
                (search || list).setAttribute('aria-activedescendant', li.id);
            }
        }

        function open() {
            if (wrap.classList.contains('open')) return;
            $$('.select.open').forEach((other) => other !== wrap && other.dispatchEvent(new Event('select:close')));
            wrap.classList.add('open');
            btn.setAttribute('aria-expanded', 'true');
            if (search) { search.value = ''; filter(''); }
            setActive(items.find((li) => li.getAttribute('aria-selected') === 'true') || visible()[0]);
            setTimeout(() => (search || list).focus({ preventScroll: true }), 60);
        }

        function close(focusBtn) {
            if (!wrap.classList.contains('open')) return;
            wrap.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
            if (focusBtn) btn.focus();
        }

        function choose(li) {
            select.value = li.dataset.value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
            sync();
            close(true);
            if (otherBox && select.value === '__other') {
                setTimeout(() => $('input', otherBox).focus(), 350);
            }
        }

        function filter(text) {
            const needle = text.trim().toLowerCase();
            let shown = 0;
            items.forEach((li) => {
                const match = li.classList.contains('is-other') || li.textContent.toLowerCase().includes(needle);
                li.hidden = !match;
                if (match && !li.classList.contains('is-other')) shown++;
            });
            empty.hidden = shown > 0 || !needle || !items.some((li) => li.classList.contains('is-other'));
            setActive(visible()[0]);
        }

        function onKey(e) {
            const vis = visible();
            const idx = vis.indexOf(items[active]);
            if (e.key === 'ArrowDown') { e.preventDefault(); setActive(vis[Math.min(idx + 1, vis.length - 1)]); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); setActive(vis[Math.max(idx - 1, 0)]); }
            else if (e.key === 'Home') { e.preventDefault(); setActive(vis[0]); }
            else if (e.key === 'End') { e.preventDefault(); setActive(vis[vis.length - 1]); }
            else if (e.key === 'Enter' || (e.key === ' ' && e.target !== search)) { e.preventDefault(); if (items[active] && !items[active].hidden) choose(items[active]); }
            else if (e.key === 'Escape') { e.preventDefault(); close(true); }
            else if (e.key === 'Tab') { close(false); }
        }

        btn.addEventListener('click', () => (wrap.classList.contains('open') ? close(true) : open()));
        btn.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') { e.preventDefault(); open(); }
        });
        list.addEventListener('click', (e) => { const li = e.target.closest('li'); if (li) choose(li); });
        list.addEventListener('mousemove', (e) => { const li = e.target.closest('li'); if (li && items[active] !== li) setActive(li); });
        list.addEventListener('keydown', onKey);
        if (search) {
            search.addEventListener('input', () => filter(search.value));
            search.addEventListener('keydown', onKey);
        }
        wrap.addEventListener('select:close', () => close(false));
        document.addEventListener('click', (e) => { if (!wrap.contains(e.target)) close(false); });

        sync();
    }
    $$('[data-select]').forEach(enhanceSelect);

    /* ---------- text input with suggestions ---------- */

    function enhanceSuggest(wrap) {
        const input = $('input', wrap);
        let data = [];
        try { data = JSON.parse(wrap.dataset.suggest || '[]'); } catch (err) { return; }
        if (!input || !data.length) return;

        const id = `sug-${++uid}`;
        const panel = el('div', { class: 'suggest-panel' });
        const list = el('ul', { role: 'listbox', id });
        panel.append(list);
        wrap.append(panel);
        input.setAttribute('role', 'combobox');
        input.setAttribute('aria-autocomplete', 'list');
        input.setAttribute('aria-controls', id);
        input.setAttribute('aria-expanded', 'false');

        let active = -1;
        let items = [];

        function close() {
            wrap.classList.remove('open');
            input.setAttribute('aria-expanded', 'false');
            active = -1;
        }

        function render() {
            const needle = input.value.trim().toLowerCase();
            const matches = data
                .filter((name) => name.toLowerCase().includes(needle))
                .sort((a, b) => a.toLowerCase().indexOf(needle) - b.toLowerCase().indexOf(needle))
                .slice(0, 8);
            list.textContent = '';
            items = matches.map((name, i) => {
                const li = el('li', { role: 'option', id: `${id}-${i}` }, name);
                list.append(li);
                return li;
            });
            active = -1;
            const exact = matches.length === 1 && matches[0].toLowerCase() === needle;
            if (matches.length && !exact) {
                wrap.classList.add('open');
                input.setAttribute('aria-expanded', 'true');
            } else {
                close();
            }
        }

        function setActive(i) {
            items.forEach((li) => li.classList.remove('active'));
            active = i;
            if (items[i]) {
                items[i].classList.add('active');
                items[i].scrollIntoView({ block: 'nearest' });
                input.setAttribute('aria-activedescendant', items[i].id);
            }
        }

        function choose(name) {
            input.value = name;
            input.dispatchEvent(new Event('input', { bubbles: true }));
            close();
            input.focus();
        }

        input.addEventListener('focus', render);
        input.addEventListener('input', (e) => { if (e.isTrusted) render(); });
        input.addEventListener('keydown', (e) => {
            if (!wrap.classList.contains('open')) return;
            if (e.key === 'ArrowDown') { e.preventDefault(); setActive(Math.min(active + 1, items.length - 1)); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); setActive(Math.max(active - 1, 0)); }
            else if (e.key === 'Enter' && active >= 0) { e.preventDefault(); choose(items[active].textContent); }
            else if (e.key === 'Escape') { close(); }
        });
        list.addEventListener('mousedown', (e) => {
            const li = e.target.closest('li');
            if (li) { e.preventDefault(); choose(li.textContent); }
        });
        input.addEventListener('blur', () => setTimeout(close, 120));
    }
    $$('[data-suggest]').forEach(enhanceSuggest);

    /* ---------- small helpers ---------- */

    // show / hide password
    $$('[data-toggle-password]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const input = $('input', btn.parentElement);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.textContent = show ? 'Hide' : 'Show';
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        });
    });

    // image upload preview
    $$('[data-upload]').forEach((box) => {
        const input = $('input[type="file"]', box);
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            $('[data-upload-name]', box).textContent = file.name;
            if (file.type.startsWith('image/')) {
                $('.upload-preview', box).style.backgroundImage = `url(${URL.createObjectURL(file)})`;
            }
        });
    });

    // confirm before deleting
    $$('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => { if (!window.confirm(form.dataset.confirm)) e.preventDefault(); });
    });

    // toasts slide away on their own
    $$('[data-toast]').forEach((toast) => {
        const leave = () => { toast.classList.add('leaving'); setTimeout(() => toast.remove(), 600); };
        $('[data-toast-close]', toast).addEventListener('click', leave);
        setTimeout(leave, 6500);
    });

    // bring the first field with an error into view
    const firstError = $('.has-error');
    if (firstError) firstError.scrollIntoView({ block: 'center', behavior: 'smooth' });
})();
