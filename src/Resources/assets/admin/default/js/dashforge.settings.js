
$(function(){
  'use strict'

  // Append settings
  $.ajax({
    url: '../../settings.html',
    success: function(result){
      $('body').append(result);
      feather.replace();

      var hasMode = Cookies.get('df-mode');
      if(hasMode) {
        $('head').append('<link id="dfMode" rel="stylesheet" href="../../assets/css/skin.'+hasMode+'.css">')
        $('body').find('.df-mode').each(function(){
          var name = $(this).attr('data-title');
          if(name === hasMode) {
            $(this).addClass('active');
          } else {
            $(this).removeClass('active');
          }
        })
      }

      var hasSkin = Cookies.get('df-skin');
      if(hasSkin) {
        $('head').append('<link id="dfSkin" rel="stylesheet" href="../../assets/css/skin.'+hasSkin+'.css">')
        $('body').find('.df-skin').each(function(){
          var name = $(this).attr('data-title');
          if(name === hasSkin) {
            $(this).addClass('active');
          } else {
            $(this).removeClass('active');
          }
        })
      }
    }
  });

  // Template Customizer
  $('body').on('click', '#dfSettingsShow', function(e){
    e.preventDefault()

    $('.df-settings').toggleClass('show');
  })

  $('body').on('click', '.df-mode', function(e){
    e.preventDefault();

    if(!$(this).hasClass('disabled')) {
      $(this).parent().siblings().find('.df-mode').removeClass('active');
      $(this).addClass('active');

      var mode = $(this).attr('data-title');

      if(mode === 'classic') {
        $('#dfMode').remove();

        Cookies.remove('df-mode');
      } else {

        if($('#dfMode').length === 0) {
          if($('#dfSkin').length === 0) {
            $('head').append('<link id="dfMode" rel="stylesheet" href="../../assets/css/skin.'+mode+'.css">');
          } else {
            $('<link id="dfMode" rel="stylesheet" href="../../assets/css/skin.'+mode+'.css">').insertBefore($('#dfSkin'));
          }
        } else {
          $('#dfMode').attr('href', '../../assets/css/skin.'+mode+'.css');
        }

        Cookies.set('df-mode', mode);
      }
    }
  })

  $('body').on('click', '.df-skin', function(e){
    e.preventDefault();

    $(this).parent().siblings().find('.df-skin').removeClass('active');
    $(this).addClass('active');

    var skin = $(this).attr('data-title');

    if(skin === 'default') {
      $('#dfSkin').remove();

      Cookies.remove('df-skin');
    } else {

      if($('#dfSkin').length === 0) {
        $('head').append('<link id="dfSkin" rel="stylesheet" href="../../assets/css/skin.'+skin+'.css">')
      } else {
        $('#dfSkin').attr('href', '../../assets/css/skin.'+skin+'.css');
      }

      Cookies.set('df-skin', skin);
    }

  })

  $('body').on('click', '#setFontRoboto', function(e){
    e.preventDefault()
    $('body').addClass('df-roboto')
    $(this).addClass('active-primary');
    $('#setFontBase').removeClass('active-primary');
  })

  $('body').on('click', '#setFontBase', function(e){
    e.preventDefault()
    $('body').removeClass('df-roboto');
    $(this).addClass('active-primary');
    $('#setFontRoboto').removeClass('active-primary');
  })
})
