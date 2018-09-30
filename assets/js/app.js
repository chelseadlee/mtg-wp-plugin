"use strict";

var magicCards = new Vue({
  el: '#app',
  data: function data() {
    return {
      trigger: 2000,
      // distance from bottom to trigger infinite scroll
      typeFilter: 'Creature',
      orderBy: 'name',
      // default card order
      currentPage: 1,
      pageSize: 20,
      // amount of data per request
      loading: true,
      search: '',
      cards: [] // card data storage

    };
  },
  computed: {
    filteredList: function filteredList() {
      var _this = this;

      // filter cards by type (typeFilter) and by search input (search)
      return this.cards.filter(function (card) {
        return card.types.indexOf(_this.typeFilter) !== -1 && card.name.toLowerCase().includes(_this.search.toLowerCase());
      });
    }
  },
  methods: {
    loadCards: function loadCards() {
      var _this2 = this;

      var baseUrl = 'https://api.magicthegathering.io/v1/cards';
      axios.get(baseUrl, {
        params: {
          orderBy: this.orderBy,
          contains: 'imageUrl',
          page: this.currentPage,
          pageSize: this.pageSize
        }
      }).then(function (response) {
        _this2.cards = _this2.cards.concat(response.data.cards);
        _this2.loading = false;
      }).catch(function (error) {
        // TODO set up more thorough error handling
        console.log(error);
      });
    },
    scroll: function scroll() {
      var _this3 = this;

      // TODO throttle scroll event listener
      window.onscroll = function (ev) {
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight - _this3.trigger && !_this3.loading) {
          _this3.loadMore();
        }
      };
    },
    loadMore: function loadMore() {
      this.loading = true; // TODO get total number of cards from response headers
      // For now, calculate total number of pages using current number of cards

      var totalCards = 37530;
      var totalPages = totalCards / this.pageSize; // increment currentPage if there are more pages to load.

      if (this.currentPage < totalPages) {
        this.currentPage++;
        this.loadCards();
      }
    },
    sortCards: function sortCards(e) {
      // get option values from user selection
      var option = e.target.value;
      console.log(option); // check to make sure cards aren't already ordered by selected option

      if (option === this.orderBy) {
        return;
      } // reset data and load cards with new sort order


      this.orderBy = option;
      this.currentPage = 1;
      this.cards = [];
      this.loadCards();
    }
  },
  mounted: function mounted() {
    // Infinite Scroll after initial load
    this.scroll();
  },
  created: function created() {
    // Initial Load
    this.loadCards();
  }
});