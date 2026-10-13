<!-- Header Global Search Component Script -->
<script>
    function headerSearch() {
        return {
            query: '',
            open: false,
            loading: false,
            hasSearched: false,
            selectedIndex: -1,
            results: {
                students: [],
                classes: [],
                departments: [],
                courses: [],
                actions: []
            },
            init() {
                window.addEventListener('keydown', (e) => {
                    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                        e.preventDefault();
                        this.focusInput();
                    }
                });
            },
            get flatList() {
                const list = [];
                (this.results.actions || []).forEach(a => list.push({ ...a, flatKey: 'action_' + a.title }));
                (this.results.students || []).forEach(s => list.push({ ...s, flatKey: 'student_' + s.id }));
                (this.results.classes || []).forEach(c => list.push({ ...c, flatKey: 'class_' + c.id }));
                (this.results.departments || []).forEach(d => list.push({ ...d, flatKey: 'dept_' + d.id }));
                (this.results.courses || []).forEach(co => list.push({ ...co, flatKey: 'course_' + co.id }));
                return list;
            },
            get totalItems() {
                return this.flatList.length;
            },
            getItemIndex(flatKey) {
                return this.flatList.findIndex(item => item.flatKey === flatKey);
            },
            focusInput() {
                this.open = true;
                this.$nextTick(() => {
                    if (this.$refs.searchInput) {
                        this.$refs.searchInput.focus();
                        this.$refs.searchInput.select();
                    }
                });
                if (!this.hasSearched) {
                    this.fetchData();
                }
            },
            close() {
                this.open = false;
                this.selectedIndex = -1;
            },
            clear() {
                this.query = '';
                this.selectedIndex = -1;
                this.fetchData();
                this.$nextTick(() => {
                    this.$refs.searchInput?.focus();
                });
            },
            selectNext() {
                if (!this.open) {
                    this.open = true;
                    return;
                }
                if (this.totalItems === 0) return;
                this.selectedIndex = (this.selectedIndex + 1) % this.totalItems;
                this.scrollToSelected();
            },
            selectPrev() {
                if (!this.open) {
                    this.open = true;
                    return;
                }
                if (this.totalItems === 0) return;
                this.selectedIndex = (this.selectedIndex - 1 + this.totalItems) % this.totalItems;
                this.scrollToSelected();
            },
            scrollToSelected() {
                this.$nextTick(() => {
                    const el = this.$refs.dropdown?.querySelector('[data-selected="true"]');
                    if (el) {
                        el.scrollIntoView({ block: 'nearest' });
                    }
                });
            },
            onEnter(event) {
                if (this.selectedIndex >= 0 && this.flatList[this.selectedIndex]) {
                    event.preventDefault();
                    this.navigate(this.flatList[this.selectedIndex].url);
                }
            },
            onFormSubmit(event) {
                if (this.selectedIndex >= 0 && this.flatList[this.selectedIndex]) {
                    event.preventDefault();
                    this.navigate(this.flatList[this.selectedIndex].url);
                }
            },
            navigate(url) {
                if (url) {
                    this.open = false;
                    window.location.href = url;
                }
            },
            async fetchData() {
                this.loading = true;
                try {
                    const trimmed = this.query.trim();
                    const url = '{{ route('global.search') }}?q=' + encodeURIComponent(trimmed);
                    const res = await fetch(url, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.results = {
                            students: data.students || [],
                            classes: data.classes || [],
                            departments: data.departments || [],
                            courses: data.courses || [],
                            actions: data.actions || []
                        };
                        this.hasSearched = true;
                        this.selectedIndex = -1;
                    }
                } catch (err) {
                    console.error('Global search error:', err);
                } finally {
                    this.loading = false;
                }
            }
        };
    }
</script>
