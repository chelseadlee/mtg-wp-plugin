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
        add_shortcode($this->shortcode_name, [$this, 'render_frontend']);
    }

    /**
     * Render frontend app
     *
     * @return string
     */
    public function render_frontend() {
        wp_enqueue_style('bootstrap');
        wp_enqueue_style('magiccards-frontend');
        wp_enqueue_script('vue');
        wp_enqueue_script('axios');
        wp_enqueue_script('magiccards-frontend');

        $content = '
                <section id="app" class="app container">
                        <h1 class="main-title text-center my-5">MTG: The Deck</h1>
                        <div class="row my-2">
                            <div class="input-group col-xs-12 col-sm-6 my-3">
                                <input type="search" class="form-control" id="card-search" name="q" v-model="search" placeholder="Search by name..." aria-label="Search cards by name">
                                <button class="btn search-btn" type="button">Go!</button>
                            </div>
                            <div class="input-group col-xs-12 col-sm-6 my-3">
                                <select v-on:change="sortCards" class="form-control">
                                    <option>Sort By...</option>
                                    <option>Card Name</option>
                                    <option>Set Name</option>
                                    <option>Artist</option>
                                    <option>Power</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" v-show="filteredList">
                            <div class="col" v-for="card in filteredList" :key="card.id">
                                <div class="card" >
                                    <img class="card-img-top" v-bind:src="card.imageUrl" v-bind:alt="card.name"/>
                                    <div class="card-body">
                                        <h5 class="card-title">{{card.name}}</h5>
                                        <span class="card-text"><span class="label">Artist:</span> {{card.artist}}</span><br>
                                        <span class="card-text"><span class="label">Set Name:</span> {{card.setName}}</span><br>
                                        <span class="card-text"><span class="label">Original Type:</span> {{card.originalType}}</span><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="loading-spinner my-5" role="alert" aria-live="assertive" v-if="loading"><span class="sr-only">Loading</span></div>
                    </section>
                    ';
        return $content;
    }

}
