<?php

namespace MTGApp;

/**
 * Frontend Pages Handler
 */
class Frontend {

    /**
     * Shortcode Name
     *
     * @var string
     */
    private $shortcode_name = 'magic-cards';


    public function __construct() {
        add_shortcode($this->shortcode_name, array( $this, 'render_frontend' ));
    }

    /**
     * Render frontend app
     *
     * @return string
     */
    public function render_frontend() {
        wp_enqueue_style('magiccards-frontend');
        wp_enqueue_script('magiccards-frontend');

        $content = '
                <section id="app" class="app container">
                    <h1 class="main-title text-center my-5">MTG: The Deck</h1>
                    <div class="row my-2">
                        <div class="input-group col-xs-12 col-sm-6 my-3">
                            <input type="search" class="form-control" id="card-search" name="q" v-model="search" placeholder="Search by name..." aria-label="Search cards by name" v-on:change="searchCards">
                            <button class="btn search-btn" type="button">Search</button>
                        </div>
                        <div class="input-group col-xs-12 col-sm-6 my-3">
                            <label class="sort-label" for="sort">Sort Cards</label>
                            <select id="sort" v-on:change="sortCards" class="form-control">
                                <option disabled selected value="">Sort By...</option>
                                <option value="name">Card Name (Default)</option>
                                <option value="setName">Set Name</option>
                                <option value="artist">Artist</option>
                                <option value="power">Power</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" v-show="filteredList" tabindex="-1">
                        <div class="col" v-for="card in filteredList" :key="card.id" tabindex="-1">
                            <article class="card" tabindex="0">
                                <img class="card-img-top" v-bind:src="card.imageUrl" v-bind:alt="card.name"/>
                                <div class="card-body">
                                    <h2 class="card-title">{{card.name}}</h2>
                                    <ul>
                                        <li class="card-text"><span class="label">Artist:</span> {{card.artist}}</li><br>
                                        <li class="card-text"><span class="label">Set Name:</span> {{card.setName}}</li><br>
                                        <li class="card-text"><span class="label">Power:</span> {{card.power}}</li><br>
                                        <li class="card-text"><span class="label">Original Type:</span> {{card.originalType}}</li><br>
                                    </ul>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="loading-spinner my-5" role="alert" aria-live="assertive" v-if="loading"><span class="sr-only">Loading</span></div>
                </section>
                ';
        return $content;
    }

}
