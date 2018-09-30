const magicCards = new Vue({
    el: '#app',
    data() {
        return {
            trigger: 2000, // distance from bottom to trigger infinite scroll
            typeFilter: 'Creature',
            orderBy: 'name', // default card order
            sortOptions: [
                { text: 'Sort By...', value: 'name' },
                { text: 'Card Name', value: 'name' },
                { text: 'Set Name', value: 'setName' },
                { text: 'Artist', value: 'artist' },
                { text: 'Power', value: 'power' },
            ],
            currentPage: 1,
            pageSize: 100, // amount of data per request
            loading: true,
            search: '',
            cards: [] // card data storage
        }
    },
    computed: {
        filteredList() {
            // filter cards by type (typeFilter) and by search input (search)
            return this.cards.filter((card) => {
                return card.types.indexOf(this.typeFilter) !== -1 && card.name.toLowerCase().includes(this.search.toLowerCase());
            });
        }
    },
    methods: {
        loadCards: function () {
            let baseUrl = 'https://api.magicthegathering.io/v1/cards';
            axios.get(baseUrl, {
                params: {
                    orderBy: this.orderBy,
                    contains: 'imageUrl',
                    page: this.currentPage
                }
            })
                .then((response) => {
                    this.cards = this.cards.concat(response.data.cards);
                    this.loading = false;
                })
                .catch(error => {
                    // TODO set up more thorough error handling
                    console.log(error);
                })
        },
        scroll: function () {
            // TODO throttle scroll event listener
            window.onscroll = ev => {
                if (window.innerHeight + window.scrollY >= (document.body.offsetHeight - this.trigger) && !this.loading) {
                    this.loadMore();
                }
            }
        },
        loadMore: function () {
            this.loading = true;

            // TODO get total number of cards from response headers
            // For now, calculate total number of pages using current number of cards
            const totalCards = 37530;
            const totalPages = totalCards / this.pageSize;

            // increment currentPage if there are more pages to load
            if (this.currentPage < totalPages) {
                this.currentPage++;
                this.loadCards();
            }
        },
        sortCards(e) {
            // get option values from user selection
            const option = this.sortOptions.find((o) => {
                return o.text === e.target.value;
            });

            // reset data and load cards
            this.orderBy = option.value;
            this.currentPage = 1;
            this.cards = [];
            this.loadCards();
        }
    },
    mounted: function () {
        // Infinite Scroll after initial load
        this.scroll();
    },
    created() {
        // Initial Load
        this.loadCards();
    }
});