jQuery(document).ready(function ($) {
  $('select[name="location"]').on("change", function () {
    if ($(this).val() !== "all") {
      activateRadiusSearch();
      activateCitySearch();
    } else {
      deactivateRadiusSearch();
      deactivateCitySearch();
    }
  });
  $("#stellenanzeigen_shortcode_generator_form").submit(function (e) {
    e.preventDefault();
    let companyValue = $('input[name="company"]').val();
    let industryValue = $('input[name="industry"]').val();
    let typeValue = $('input[name="type"]').val();
    let tokenValue = $('input[name="token"]').val();
    let hideTypeValue = $('input[name="hide_type"]').val();
    let withFilter = $('input[name="with_filter"]').is(':checked');

    let hoverColorValue = $('input[name="hover_color"]').val();

    let sortingValue = $('select[name="sorting"]').val();
    let shortcode = `[job_list`;
    if (companyValue !== "") {
      shortcode += ` company="${companyValue}"`;
    }
    if (industryValue !== "") {
      shortcode += ` industry="${industryValue}"`;
    }
    if (typeValue !== "") {
      shortcode += ` type="${typeValue}"`;
    }
    if (hoverColorValue !== "") {
      shortcode += ` hover_color="${hoverColorValue}"`;
    }
    if (hideTypeValue !== "") {
      shortcode += ` hide_type="${hideTypeValue}"`;
    }
    if (sortingValue) {
      shortcode += ` sorting="${sortingValue}"`;
    }
    if (tokenValue !== "") {
      shortcode += ` token="${tokenValue}"`;
    }
    if (withFilter) {
      shortcode += ` with_filter="true"`;
    }
    shortcode += `]`;
    $("#shortcode-view").html(shortcode);

    $("#shortcode-modal").addClass("is-active");
  });
  $("#close-shortcode-modal").click(function () {
    $("#shortcode-modal").removeClass("is-active");
  });
  $("#copy-shortcode").click(function () {
    // copy to clipboard shortcode-view div content
    const text = $("#shortcode-view").text();
    navigator.clipboard.writeText(text);
    // change button text
    $(this).html("Shortcode Copied");
    $(this).addClass("is-success");
    setTimeout(function () {
      $("#copy-shortcode").removeClass("is-success");
      $("#copy-shortcode").html("Copy Shortcode");
    }, 2000);
  });
  $("#filter_jobs_search").click(function () {
    let searchValue = $('input[name="search_job"]').val();
    let locationValue = $('select[name="location"]').val();
    let radiusValue = $('select[name="radius"]').val();
    let cityValue = $('select[name="city"]').val();
    let zipValue = $('input[name="zip"]').val();
    let nonce = $('input[name="jobs_ajaxFilter_name"]').val();
    searchJob(
      searchValue,
      locationValue,
      radiusValue,
      cityValue,
      zipValue,
      nonce
    );
  });
  function searchJob(
    searchValue,
    locationValue,
    radiusValue,
    cityValue,
    zipValue,
    nonce
  ) {
    $.ajax({
      type: "POST",
      data: {
        search: searchValue,
        location: locationValue,
        radius: radiusValue,
        city: cityValue,
        zip: zipValue,
        nonce: nonce,
        action: "jobs_ajaxFilter",
      },
      url: js_variables.ajaxurl,
      beforeSend: function () {
        $(".stellenanzeigen__joblist").html(
          '<img class="stellenanzeigen__loader" src="' +
            js_variables.pluginUrl +
            'assets/Loading_icon.gif">'
        );
      },
      success: function (response) {
        $(".stellenanzeigen__joblist").html(response);
      },
    });
  }
  function activateRadiusSearch() {
    $('select[name="radius"]').removeAttr("disabled");
  }
  function deactivateRadiusSearch() {
    $('select[name="radius"]').attr("disabled", "disabled");
  }

  function activateCitySearch() {
    $('select[name="city"]').removeAttr("disabled");
    let locationValue = $('select[name="location"]').val();
    let nonce = $('input[name="jobs_ajaxFilter_name"]').val();

    $.ajax({
      type: "POST",
      data: {
        location: locationValue,
        nonce: nonce,
        action: "jobs_ajaxFilter_city",
      },
      url: js_variables.ajaxurl,
      beforeSend: function () {
        $(".city_filter").html(
          '<img class="stellenanzeigen__loader" src="' +
            js_variables.pluginUrl +
            'assets/Loading_icon.gif">'
        );
      },
      success: function (response) {
        $(".city_filter").html(response);
      },
    });
  }
  function deactivateCitySearch() {
    $('select[name="city"]').attr("disabled", "disabled");
    $('select[name="city"]').html(
      '<option value="all">Wählen Sie zuerst die Region aus</option>'
    );
  }
});
