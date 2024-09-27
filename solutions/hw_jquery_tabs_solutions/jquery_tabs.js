/*
The ONLY edits you can make for this exercise are in this file.
Use JQuery objects and methods, not DOM objects.

Hints:
To set the style classes initially:
  The most understandable way to do this is to use nested iteration:
    Outer loop: iterates over the div blocks, setting styles as necessary
    Inner loop: iterates over the children which are either buttons or paragraphs. In here you can set styles and onclick event handlers as necessary.

The onclick events:
  I recommend using a named function to simply the code a bit:

  $button.click( show_tab_content );

The callback function for the button clicks:

  function show_tab_content(e) {
    // Here's some help with stuff you might need in this function

    console.log(e.target.id);  // id of button that was clicked

    JQuery Object for the clicked button
    $('#'+e.target.id)

    JQuery Object for the parent div of the clicked button
    $('#'+e.target.id).parent()

    Array of JQuery Objects for each of the buttons in the group that contains the button that was clicked.
    $('#'+e.target.id).parent().children()
  }

The default active tab:
  If you assign a function to the click() method as above, it sets it as a callback for the event.
  But if you call click() like below with no argument, it actually clicks the button (fires the onclick event).

  $button.click();
*/


$(document).ready( function() {

  $('div').each( function() {
      let $div = $(this);  // current div block in iteration
      //console.log($div);

      if ( $div.attr('tab-controls') ) {          // wrapper block for the buttons
          $div.addClass('tab_block');
          $div.children().addClass('tab_button');

          // loop over the buttons to set up an event handler for each one
          $div.children().each( function() {
            let $button = $(this); // current button in iteration
            $button.click( show_content_for_tab );
          }); // end inner loop iterator
      }
      else if ($div.attr('tab-content')) {    // wrapper block for the content blocks
          $div.children().each( function() {
            let $p = $(this); // current paragraph in iteration
            $p.addClass('tab_content');
          }); // end inner loop iterator

      }

  }); // end outer loop iterator

  $('button[tab-default-active]').click();

}); // End JQuery Ready Event Callback.



function show_content_for_tab(e) {
  console.log(e.target.id);  // id of button that was clicked

  // remove active state from any previously active button in group
  $('#'+e.target.id).parent().children().removeClass('tab_button_active');

  // make the clicked button active
  $('#'+e.target.id).addClass('tab_button_active');

  // access the parent of the clicked button to find the name of the tab group tab-controls="cities"
  var tab_group_name = $('#'+e.target.id).parent().attr('tab-controls');
  console.log(tab_group_name);

  // remove any currently displayed content in the group
  $('[tab-content="'+tab_group_name+'"]').children().removeClass('tab_content_active');

  // show the content that matches the id of the clicked button
  $('[tab-content-for="'+e.target.id+'"]').addClass('tab_content_active');

}
