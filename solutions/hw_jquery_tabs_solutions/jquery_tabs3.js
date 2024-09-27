/*
An interesting student solution from Anastasijia.
Similar to my Solution #2 but some interesting stuff in showTabContent() callback:
  .closest()
  .siblings()
*/

$(document).ready(function () {

  // Initialize each tab system
  $('[tab-controls]').each(function () {
    const $tabButtons = $(this).children('button');
    const tabGroup = $(this).attr('tab-controls');

    // Add classes and bind events for buttons
    $tabButtons.addClass('tab_button').on('click', showTabContent);

    // Initialize content: Add the tab_content class to all paragraphs
    $(`div[tab-content="${tabGroup}"] p`).addClass('tab_content');

    // Add the wrapper class to the tab block for layout
    $(this).addClass('tab_block');

    // Reset any active classes for buttons and content on initial page load
    $tabButtons.removeClass('tab_button_active');
    $(`div[tab-content="${tabGroup}"] p`).removeClass('tab_content_active');

    // Click buttons for active tabs
    $('button[tab-default-active]').click();

  });


  // Function to display the content associated with the clicked tab button
  function showTabContent(e) {
    const $clickedButton = $(e.target);
    const tabGroup = $clickedButton.closest('[tab-controls]').attr('tab-controls');

    // Activate the clicked button and deactivate the other buttons
    $clickedButton.addClass('tab_button_active').siblings().removeClass('tab_button_active');

    // Show the content corresponding to the selected tab and hide others
    $(`div[tab-content="${tabGroup}"] p`).removeClass('tab_content_active');
    $(`p[tab-content-for="${$clickedButton.attr('id')}"]`).addClass('tab_content_active');
  }

});
 // End JQuery Ready Event Callback.
