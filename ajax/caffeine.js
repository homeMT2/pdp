function Caffeine(){
    
  this.os_version = 'unknown'; 
  this.isIOS = navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false;
  this.isAndroid = navigator.userAgent.match(/(Android)/g) ? true : false;
  this.isChrome = navigator.userAgent.match(/(CriOS|Chrome)/g) ? true : false;
  this.isSafari = (!this.isChrome && navigator.userAgent.match(/(Safari)/g)) ? true: false;
  
  if(this.isIOS) {
    var ua = navigator.userAgent;
    var uaindex = ua.indexOf( 'OS ' );
    this.os_version = ua.substr( uaindex + 3, 3 ).replace( '_', '.' );
   }
  
  if(this.isAndroid) {
    var uaindex  = navigator.userAgent.indexOf( 'Android ');
    var os_version = navigator.userAgent.substr( uaindex + 8, 3 );
    this.os_version = Number(os_version);
  }  

  
  this.osVersion = this.os_version;
  this.awakeLoop = null;
  this.mediaEl = null;

  this.audio_file = 'http://phonedown.com/wp-content/themes/petrichor/jqmobile/assets/audio/silence.mp3';
  this.video_file = 'http://phonedown.com/wp-content/themes/petrichor/jqmobile/assets/video/silence.mp4';
//  this.video_file = '../video/silence.webmsd.webm';
//  this.video_file = 'http://static.pin-point.io/video/silence.mp4';
//  this.video_file = 'http://techslides.com/demos/sample-videos/small.mp4';
}

Caffeine.prototype.init = function(){
//    if (!this.isIOS && !this.isAndroid) return false;
    if (!this.isIOS && !this.isAndroid) {
        this.createMediaLoop('video', this.video_file);
    };
    if(this.isIOS && this.isSafari && this.osVersion >= 7) {
      clearInterval(this.awakeLoop);
      this.createIntervalLoop();
    } else if(this.isIOS) {
        this.createMediaLoop('video', this.video_file);
//      this.createMediaLoop('audio', this.audio_file);
    } else {
      this.createMediaLoop('video', this.video_file);
    }
};

Caffeine.prototype.start = function(){
  if(this.isIOS && this.isSafari && this.osVersion >= 7) {
    this.createIntervalLoop();
  }
  if(this.mediaEl !== null) {
//    this.mediaEl.play();
  }
};

Caffeine.prototype.stop = function() {
  clearInterval(this.awakeLoop);
  if(this.mediaEl !== null) {
    this.mediaEl.pause();
  }
};

Caffeine.prototype.createIntervalLoop = function() {
  
  this.awakeLoop = setInterval(function(){
      window.location.href = "droga5.com";
      setTimeout(function(){
          window.stop();
      },0);
  }, 2e4);
};

Caffeine.prototype.createMediaLoop = function(media_type, media_file) {
  

  if(this.mediaEl !== null) {
    return false;
  }

  this.mediaEl = null;
  this.mediaEl = document.createElement(media_type);
  this.mediaEl.setAttribute('class', 'mediaLoop');
  this.mediaEl.setAttribute('preload', 'auto');

  var mediaSource = document.createElement('source');
  mediaSource.setAttribute('src', media_file);

  switch(media_type) {
    case 'audio':
      this.mediaEl.setAttribute('loop', 'true');
      mediaSource.setAttribute('type', 'audio/mpeg');
      break;
    case 'video':
      mediaSource.setAttribute('type', 'video/mp4');
      
      /*adibr70*/
      this.mediaEl.className = this.mediaEl.className + " video-js vjs-default-skin";
      this.mediaEl.setAttribute('id', 'myVideo');
      /*End adibr70*/

      // this.mediaEl.addEventListener('canplay', function() {
      //   this.play();
      // });
//      var _self = this;
      
//      this.mediaEl.addEventListener('ended', function() {
//          
//        // alert(_self.currentTime);
//        _self.mediaEl.currentTime = 0;
//        _self.mediaEl.play();
//      }, false);
      break;
  }

  this.mediaEl.addEventListener('loadeddata', function() {
    $('.events_fired').append('<div>' + media_type + ' loaded</div>');
    
  }, false);

  this.mediaEl.appendChild(mediaSource);
  document.body.appendChild(this.mediaEl);
  
//  if ($(".mediaLoop").length > 0){
//    alert($(".mediaLoop").getAttribute("src"));
// }

//  this.mediaEl.volume = 0;
  this.start();
};
