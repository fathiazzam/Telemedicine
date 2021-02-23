
// Enable video on the page.
function enableVideo() {
  loadVideoWebRTC();
}
function enableAudio() {
  loadAudioWebRTC();
}
// Dynamically load the simplewebrtc script so that we can
// kickstart the video call.
function loadVideoWebRTC() {
  var webrtc = new SimpleWebRTC({
    // the id/element dom element that will hold "our" video
    localVideoEl: 'selfVideo',
    // the id/element dom element that will hold remote videos
    remoteVideosEl: '',
    // immediately ask for camera access
    autoRequestMedia: true,
    debug: false,
    detectSpeakingEvents: true,
    autoAdjustMic: false
  });
  webrtc.on('readyToCall', function () {
    // you can name it anything
    webrtc.joinRoom('your awesome room name');
  });
  webrtc.on('videoAdded', function (video, peer) {
    console.log('video added', peer);
    var remotes = document.getElementById('remotes');
    if (remotes) {
        var container = document.createElement('div');
        container.className = 'videoContainer';
        container.id = 'container_' + webrtc.getDomId(peer);
        container.appendChild(video);
          // suppress contextmenu
        video.oncontextmenu = function () { return false; };

        // resize the video on click
        container.appendChild(video).style.width = video.videoWidth + '85%';
        container.appendChild(video).style.height = video.videoHeight + '85%';

                    // show the remote volume
        var vol = document.createElement('meter');
        vol.id = 'volume_' + peer.id;
        vol.className = 'volume';
        vol.min = -45;
        vol.max = -20;
        vol.low = -40;
        vol.high = -25;
        container.appendChild(vol);

        // show the ice connection state
        if (peer && peer.pc) {
            var connstate = document.createElement('div');
            connstate.className = 'connectionstate';
            container.appendChild(connstate);
            peer.pc.on('iceConnectionStateChange', function (event) {
                switch (peer.pc.iceConnectionState) {
                case 'checking':
                    connstate.innerText = 'Connecting to peer...';
                    break;
                case 'connected':
                case 'completed': // on caller side
                    $(vol).show();
                    connstate.innerText = 'Connection established.';
                    break;
                case 'disconnected':
                    connstate.innerText = 'Disconnected.';
                    break;
                case 'failed':
                    connstate.innerText = 'Connection failed.';
                    break;
                case 'closed':
                    connstate.innerText = 'Connection closed.';
                    break;
                }
            });
          }
        remotes.appendChild(container);
    }
  });
  // a peer video was removed
  webrtc.on('videoRemoved', function (video, peer) {
      console.log('video removed ', peer);
      var remotes = document.getElementById('remotes');
      var el = document.getElementById(peer ? 'container_' + webrtc.getDomId(peer) : 'localScreenContainer');
      if (remotes && el) {
          remotes.removeChild(el);
      }
  });
  // local p2p/ice failure
  webrtc.on('iceFailed', function (peer) {
      var connstate = document.querySelector('#container_' + webrtc.getDomId(peer) + ' .connectionstate');
      console.log('local fail', connstate);
      if (connstate) {
          connstate.innerText = 'Connection failed.';
          fileinput.disabled = 'disabled';
      }
  });

  // remote p2p/ice failure
  webrtc.on('connectivityError', function (peer) {
      var connstate = document.querySelector('#container_' + webrtc.getDomId(peer) + ' .connectionstate');
      console.log('remote fail', connstate);
      if (connstate) {
          connstate.innerText = 'Connection failed.';
          fileinput.disabled = 'disabled';
      }
  });
  function showVolume(el, volume) {
    console.log('showVolume', volume, el);
    if (!el) return;
    if (volume < -45) volume = -45; // -45 to -20 is
    if (volume > -20) volume = -20; // a good range
    el.value = volume;
  }
  // local volume has changed
  webrtc.on('volumeChange', function (volume, treshold) {
      showVolume(document.getElementById('localVolume'), volume);
  });
  // remote volume has changed
  webrtc.on('remoteVolumeChange', function (peer, volume) {
      showVolume(document.getElementById('volume_' + peer.id), volume);
  });
}

function loadAudioWebRTC(){
  var connection = new RTCMultiConnection();
  connection.session = {
      audio: true
  };
  connection.connect();
  btnStartVoiceOnlyCall.onclick = function() {
      connection.open();
  };
}