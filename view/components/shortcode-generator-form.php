<?php

namespace Stellenanzeigen\View\Components;

if (!defined('ABSPATH')) exit;

?>

<form method="post" id="stellenanzeigen_shortcode_generator_form">
  <div class="stellenanzeigen__form_container">
    <div class="stellenanzeigen__form_section">
      <label class="stellenanzeigen__form_section_label">Authorization</label>
      <div class="stellenanzeigen__form_row">
        <input name="company" class="stellenanzeigen__form_input" placeholder="Company" />
        <input name="token" class="stellenanzeigen__form_input" placeholder="Token" />
      </div>
    </div>
    <div class="stellenanzeigen__form_section">
      <label class="stellenanzeigen__form_section_label">Filter</label>
      <div class="stellenanzeigen__form_row">
        <input name="type" class="stellenanzeigen__form_input" placeholder="Type" />
        <input name="hide_type" class="stellenanzeigen__form_input" placeholder="Hide Type" />
      </div>
      <div class="stellenanzeigen__form_row">
        <input name="industry" class="stellenanzeigen__form_input" placeholder="Industry" />
        <select name="sorting" placeholder="Sorting" class="stellenanzeigen__form_select">
          <option value="" disabled selected>Sorting</option>
          <option value="asc">Ascending</option>
          <option value="desc">Descending</option>
        </select>
      </div>
    </div>
    <div class="stellenanzeigen__form_section">
      <label class="stellenanzeigen__form_section_label">Style</label>
      <div class="stellenanzeigen__form_row">
        <input type="color" name="hover_color" class="stellenanzeigen__form_input" id="hover_color" />
      </div>
    </div>
    <div class="stellenanzeigen__form_section">
      <label class="stellenanzeigen__form_section_label">Filter anzeigen</label>
      <div class="stellenanzeigen__form_row">
        <input type="checkbox" name="with_filter" class="stellenanzeigen__form_input" id="with_filter" />
      </div>
    </div>
    <div class="stellenanzeigen__form_submit_section">
      <input type="submit" value="Generate Shortcode" />
    </div>
  </div>
</form>

<div id="shortcode-modal" class="stellenanzeigen__modal">
  <div class="stellenanzeigen__modal-view">
    <h2>Shortcode</h2>
    <div class="stellenanzeigen__modal-shortcode-view" id="shortcode-view"></div>
    <div class="stellenanzeigen__modal_button_section">
      <button id="close-shortcode-modal">Schließen</button>
      <button id="copy-shortcode">Shortcode Kopieren</button>
    </div>
  </div>
</div>