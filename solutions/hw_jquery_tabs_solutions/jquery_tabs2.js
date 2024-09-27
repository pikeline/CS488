/*
Solution #2 - Using the Full Power of JQuery

JQuery methods have built in iterators!
If you call them on an array of objects, it will call the method on each object.
*/


$(document).ready( function() {

  // style the wrapper block for the buttons
  $('div[tab-controls]').addClass('tab_block');

  // style the buttons
  $('div[tab-controls]').children().addClass('tab_button');

  // style the content blocks (initially hides them all)
  $('p[tab-content-for]').addClass('tab_content');

  // click all buttons that should be be active by default when the page loads
  $('button[tab-default-active]').click();


  // event handler for the buttons - anonymous callback
  $('div[tab-controls]').children().click( function(e) {
    console.log(e.target.id);  // id of button that was clicked

    // remove active state from any previously active button in group
    $('#'+e.target.id).parent().children().removeClass('tab_button_active');

    // make the clicked button active
    $('#'+e.target.id).addClass('tab_button_active');

    // access the parent of the clicked button to find the name of the tab group tab-controls="cities"
    tab_group_name = $('#'+e.target.id).parent().attr('tab-controls');
    console.log(tab_group_name);

    // remove any currently displayed content in the group
    $('[tab-content="'+tab_group_name+'"]').children().removeClass('tab_content_active');

    // show the content that matches the id of the clicked button
    $('[tab-content-for="'+e.target.id+'"]').addClass('tab_content_active');
  });


}); // End JQuery Ready Event Callback.
