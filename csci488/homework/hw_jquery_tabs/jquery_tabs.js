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
"use strict";

$(document).ready(function () {
  // put your code in here to ensure all the JQuery objects exist when your code runs.
  $('p[tab-content-for]').each(function() {
    $(this).addClass("tab_content");
  });
  $('div[tab-controls]').each(function() {
    $(this).addClass("tab_block");
    $(this).children().each(function() {
      $(this).addClass("tab_button");
      $(this).click(active_tab);
      if($(this).attr("tab-default-active") === ""){
        $(this).addClass("tab_button_active");
        activate_tab_content($(this).attr("id"));
      }
    });
  });

  function active_tab(){
    $(this).parent().children().each(function() {
      $(this).removeClass("tab_button_active");
    });
    $(this).addClass("tab_button_active");
    activate_tab_content($(this).attr("id"));
  }
  function activate_tab_content(name){
    $('p[tab-content-for]').each(function() {
      if ($(this).attr("tab-content-for") === name){
        $(this).parent().children().each(function(){
          $(this).removeClass("tab_content_active");
        });
        $(this).addClass("tab_content_active");
      }
    });
  }
}); // End JQuery Ready Event Callback.
