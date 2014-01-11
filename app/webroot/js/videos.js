url = location.protocol + '//' + location.host;

function showVideo(id) {
  $('.videoContent').hide(250);
  $('.hideButton').hide();
  $('.showButton').show();
  $('.videoContent' + id).show(500);
  $('.showButton' + id).hide();
  $('.hideButton' + id).show();
}

function hideVideo(id) {
  $('.playerContent' + id).html('1');
  $('.videoContent' + id).hide(250);
  $('.showButton' + id).show();
  $('.hideButton' + id).hide();
}

function writeVLC(id, ext) {
  //~ $('.debug').html(url + "/videos/get/" + id + "/video." + ext);
  $('.playerContent' + id).html('');
  html = '<embed \
                type="application/x-vlc-plugin" \
                pluginspage="http://www.videolan.org"\
                version="VideoLAN.VLCPlugin.2"\
                target="' + url + '/videos/get/' + id + '/video.'+ext+'" \
                width="800"\
                height="600"\
                autostart="no"\
                controls="yes"\
                loop="no"\
                hidden="no" \
              />';
  $('.playerContent' + id).html(html);
}

function writeHTML5(id, mime, ext) {
  //~ $('.debug').html(url + "/videos/get/" + id + "/video." + ext);
  $('.playerContent' + id).html('');
  html = '<video width="800" height="600" controls>\
              <source src="'+url+'/videos/get/'+id+'/video.'+ext+'" type="'+mime+'">\
              Your browser does not support the video tag.\
          </video> ';
  $('.playerContent' + id).html(html);
}

function writeJW(id, filename, ext) {
  //~ $('.debug').html(url + "/videos/get/" + id + "/video." + ext);
  $('.playerContent' + id).html("<span id='jwPlayerContent" + id + "'></span>");
  jwplayer('jwPlayerContent' + id)
    .setup(
      {
        file: url + "/videos/get/" + id + "/video." + ext, 
        width: "800", 
        height: "600", 
        title: filename
      }
    );
}

