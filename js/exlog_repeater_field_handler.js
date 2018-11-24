// Possible data structure

var possible_repeater_data_master = [
  {
    "field_name": "title",
    "repeater_field": false,
    "field_data": "this is some text"
  },
  {
    "field_name": "Names Repeater",
    "repeater_field": true,
    "field_data": [
      {
        "field_name": "title in repeater",
        "repeater_field": false,
        "field_data": "this is some textoooo"
      },
      {
        "field_name": "title in repeater222",
        "repeater_field": false,
        "field_data": "this is some textoooo222"
      },
      {
        "field_name": "inner_repeater",
        "repeater_field": true,
        "field_data": [
          {
            "field_name": "title in repeater333",
            "repeater_field": false,
            "field_data": "this is some textoooo3333"
          },
          {
            "field_name": "title in repeater3331",
            "repeater_field": false,
            "field_data": "this is some textoooo3332"
          }
        ]
      }
    ]
  }
];

(function ($) {
  $(function () {
    // On first load, use the data rendered in the input value to build the other markup
    // - Start with all parent items
    // - - Generate markup for each version
    // - - - If field is repeater field - nest inside that

    var parent_repeater_fields = $(".option-container.repeater.exlog-repeater-master");

    parent_repeater_fields.each(function () {
      var $parent_repeater = $(this);

    });


    var $repeater_buttons = $(".exlog_repeater_add_button");
    var repeater_item_selector = ".repeater_item";
    var repeater_data_attr = 'data-exlog-repeater-id';
    var master_markup_item_selector = repeater_item_selector + '[' + repeater_data_attr + '="0"]';

    $repeater_buttons.click(on_add_button_click);

    function on_add_button_click() {
      var $button = $(this);
      console.log($button.siblings().length);

      var $add_more_container = $button.closest(".add_more");

      // Get the markup to copy from looking at first item
      var markup = $add_more_container
        .siblings(master_markup_item_selector)
        .html();

      var $markup = $('<div class="repeater_item">' + markup + '</div>');

      var used_ids = [];
      // Store all used ids
      $add_more_container.siblings(repeater_item_selector).each(function () {
        var $repeater_item = $(this);
        $repeater_item.css("background-color", "lime");
        var repeater_item_id = $repeater_item.attr(repeater_data_attr);
        used_ids.push(repeater_item_id)
      });

      // Delete any repeater ids that are not 0
      $(repeater_item_selector, $markup).each(function () {
        var $repeater_item = $(this);
        if ($repeater_item.attr(repeater_data_attr) !== "0") {
          $repeater_item.remove();
        }

      });

      // Get a unique id for the new repeater item
      var new_id = 1;
      while (used_ids.indexOf(new_id.toString()) > -1 ) { // While new_id is in used_ids
        new_id += 1;
      }

      // Store the new id in the attr of the repeater item
      $markup.attr('data-exlog-repeater-id', new_id);

      // Add the new ID to the repeater item
      // Same as above?!
      // Re-select all repeater items for this layer
      // - If a value is changed in any of those inputs update the repeater input value
      // - Check this is working for nested repeaters

      // If item is empty remove it from the list of data

      // Place the new markup on the page
      $add_more_container.before($markup);
    }
    
    function monitorRepeaterInputs() {
      var $repeater_data_stores = $('.exlog_repeater_data_store');

      $repeater_data_stores.each(function () {
        var $inputs = $('input');
        var change_events = 'keyup paste'; // Maybe just use change?

        // Clear previous events
        $inputs.off(change_events);

        $inputs.on(change_events, (function () {
          console.log('change detected');
          update_repeater_data();
        }));
      });
    }

    function update_repeater_data() {
      var $repeater_data_stores = $('.exlog_repeater_data_store');

      $repeater_data_stores.each(function () {
        var $repeater_data_store = $(this);
        var data_for_store = {}; // Object to be populated by first child inputs of repeater
        var $repeater_items = $repeater_data_store.siblings('.repeater_item');
        $repeater_items.each(function () {
          var $repeater_data_store_direct_inputs = $(this).children('.option-container').children('input');
          $repeater_data_store_direct_inputs.each(function () {
            var $input = $(this);
            data_for_store[$input.attr('name')] = $input.val();
          }).promise().done(function () {
            console.log("DATA FOR STORE:\n", data_for_store);
            $repeater_data_store.val(JSON.stringify(data_for_store));
          });
        });
      });
    }

    monitorRepeaterInputs();

  })
}(jQuery));
