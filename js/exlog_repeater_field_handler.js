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
    var $parent_repeater_fields = $(".option-container.repeater.exlog-repeater-master");
    var repeater_buttons_selector = ".exlog_repeater_add_button";
    var repeater_item_selector = ".repeater_item";
    var repeater_data_attr = 'data-exlog-repeater-id';
    var master_markup_item_selector = repeater_item_selector + '[' + repeater_data_attr + '="0"]';
    var click_event_name = 'click';
    var change_events = ['keyup', 'paste'];
    var repeater_data_store_selector = '.exlog_repeater_data_store';

    function object_to_string_if_object(data) {
      if (typeof data === 'object') {
        try {
          data = JSON.stringify(data);
        } catch (error) {
          //  Leave data in current format
        }
      }
      return data
    }

    // option-container > repeater_item > repeater_item_input_container > option-container > input
    function place_data_from_db() {
      function place_specific_repeater_values($parent_element, data) {
      //  Put all data in the name value
        var $data_store = $parent_element.children(repeater_data_store_selector);
        var data_string;
        try {
          data_string = JSON.stringify(data);
        } catch(e) {
          data_string = false;
        }
        $data_store.val(data_string);

        // Of that data, put each value in the correct input
        for(var datum in data) {
          var input_data = object_to_string_if_object(data[datum]);
          var $input_element = $parent_element.find('> .repeater_item > .repeater_item_input_container > .option-container > [name="' + datum + '"]').val(input_data);

          // !!!!!!!!!!!!!!!!!!! Need to check if the field doesn't yet exist and create it!

          //  If the input data is a repeater field, call this function again with the relevant data and $parent element
          if ($input_element.hasClass("exlog_repeater_data_store")) {
              place_specific_repeater_values($input_element.closest('.option-container'), data[datum])
          }
        }
      }

      $parent_repeater_fields.each(function () {
        var $parent_repeater_field = $(this);
        var base_64_string = $parent_repeater_field.children(repeater_data_store_selector).val();
        var parent_repeater_data;
        try {
          parent_repeater_data = JSON.parse(atob(base_64_string));
        } catch (e) {
          parent_repeater_data = false;
        }
        place_specific_repeater_values($parent_repeater_field, parent_repeater_data)
      });

    }


    function reselect_add_buttons() {
      $(repeater_buttons_selector).off().on(click_event_name, on_add_button_click);
    }

    function on_add_button_click() {
      var $button = $(this);

      var $add_more_container = $button.closest(".add_more");

      // Get the markup to copy from looking at first item
      var markup = $add_more_container
        .siblings(master_markup_item_selector)
        .html();

      var $markup = $('<section class="repeater_item">' + markup + '</section>');

      var used_ids = [];
      // Store all used ids
      $add_more_container.siblings(repeater_item_selector).each(function () {
        var $repeater_item = $(this);
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

      // Modify name for future items
      var $markup_input = $markup.children('.repeater_item_input_container').children('.option-container').children('input, textarea');
      var $markup_name_attr = $markup_input.attr('name');
      $markup_input.attr('name', $markup_name_attr + "_:RX_" + new_id + ":");

      // Place the new markup on the page
      $add_more_container.before($markup);
      reset_watchers();
    }
    
    function monitorRepeaterInputs() {
      var change_events_string = change_events.join(' ');
      var $repeater_data_stores = $(repeater_data_store_selector);

      $repeater_data_stores.each(function () {
        var $repeater_data_store = $(this);
        var $inputs = $repeater_data_store.siblings('.repeater_item').children('.repeater_item_input_container').children('.option-container').children('input, textarea');

        // Clear previous events
        $inputs.off(change_events_string);

        $inputs.on(change_events_string, (function () {
          update_repeater_data($repeater_data_store, $inputs);
          $repeater_data_store.trigger(change_events[0]);
        }));
      });
    }

    function update_repeater_data($repeater_data_store, $child_inputs) {
      var data_for_store = {}; // Object to be populated by first child inputs of repeater
      $child_inputs.each(function () {
        var $input = $(this);
        var data = $input.val();
        try {
          data = JSON.parse(data); // If the data can be interpreted as JSON convert it to an object
        } catch(error) {
          //  Leave data as string
        }
        data_for_store[$input.attr('name')] = data;
      }).promise().done(function () {
        $repeater_data_store.val(JSON.stringify(data_for_store));
      });
    }

    function on_delete_item_click() {
      $('.delete_repeater_item').off(click_event_name).on(click_event_name, function () {
        var $delete_button = $(this);
        var $repeater_item = $delete_button.closest(repeater_item_selector);

        // var $repeater_item_name = $repeater_item.attr('name');

        var $first_item = $repeater_item.siblings(master_markup_item_selector).find('input');

        // Remove the repeater item from the DOM
        $repeater_item.remove();

        // Ensure elements no longer in the DOM are no longer selected as otherwise data is kept
        reset_watchers();

        // Make first repeater item trigger change to remove deleted items data
        $first_item.trigger(change_events[0]);
      })
    }

    // All the selectors that need updating on DOM change
    function reset_watchers() {
      monitorRepeaterInputs();
      reselect_add_buttons();
      on_delete_item_click();
    }

    place_data_from_db();
    reset_watchers();
  })
}(jQuery));
