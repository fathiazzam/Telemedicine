<!--
// Muaz Khan     - www.MuazKhan.com
// MIT License   - www.WebRTC-Experiment.com/licence
// Documentation - www.RTCMultiConnection.org
-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <script>
            if(!location.hash.replace('#', '').length) {
                location.href = location.href.split('#')[0] + '#' + (Math.random() * 100).toString().replace('.', '');
                location.reload();
            }
        </script>

        <title>WebRTC Audio_Only Calls: Realtime & Pluginfree!</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <link rel="author" type="text/html" href="https://plus.google.com/+MuazKhan">
        <meta name="author" content="Muaz Khan">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="stylesheet" href="https://cdn.webrtc-experiment.com/style.css">
        
        <style>
            audio, video {
                -moz-transition: all 1s ease;
                -ms-transition: all 1s ease;
                
                -o-transition: all 1s ease;
                -webkit-transition: all 1s ease;
                transition: all 1s ease;
                vertical-align: top;
            }

            input {
                border: 1px solid #d9d9d9;
                border-radius: 1px;
                font-size: 2em;
                margin: .2em;
                width: 30%;
            }

            .setup {
                border-bottom-left-radius: 0;
                border-top-left-radius: 0;
                font-size: 102%;
                height: 47px;
                margin-left: -9px;
                margin-top: 8px;
                position: absolute;
            }

            p { padding: 1em; }
        </style>
        <script>
            document.createElement('article');
            document.createElement('footer');
        </script>
        
        <!-- webrtc library used for streaming -->
        <script src="https://cdn.webrtc-experiment.com/socket.io.js"> </script>
        <script src="https://cdn.webrtc-experiment.com/getMediaElement.min.js"> </script>
        <script src="https://cdn.webrtc-experiment.com/RTCMultiConnection.js"> </script>
    </head>

    <body>
        <article>
            <header style="text-align: center;">
                <h1>
                    WebRTC Audio_Only Calls: Realtime & Pluginfree!
                </h1>            
                <p>
                    <a href="https://www.webrtc-experiment.com/">HOME</a>
                    <span> &copy; </span>
                    <a href="http://www.MuazKhan.com/" target="_blank">Muaz Khan</a>
                    
                    .
                    <a href="http://twitter.com/WebRTCWeb" target="_blank" title="Twitter profile for WebRTC Experiments">@WebRTCWeb</a>
                    
                    .
                    <a href="https://github.com/muaz-khan?tab=repositories" target="_blank" title="Github Profile">Github</a>
                    
                    .
                    <a href="https://github.com/muaz-khan/WebRTC-Experiment/issues?state=open" target="_blank">Latest issues</a>
                    
                    .
                    <a href="https://github.com/muaz-khan/WebRTC-Experiment/commits/master" target="_blank">What's New?</a>
                </p>
            </header>

            <div class="github-stargazers"></div>
        
            <!-- just copy this <section> and next script -->
            <section class="experiment">
				<section>
                    <span>
                        Private ?? <a href="/calls/" target="_blank" title="Open this link in new tab. Then your conference room will be private!"><code><strong id="unique-token">#123456789</strong></code></a>
                    </span>
                    
                    <input type="text" id="user-name" placeholder="Your Name">
                    <button id="setup-voice-only-call" class="setup">Setup Voice-only Call</button>
                </section>
				
                <!-- list of all available broadcasting rooms -->
                <table style="width: 100%;" id="rooms-list"></table>
                
                <!-- local/remote videos container -->
                <div id="audios-container"></div>
            </section>
        
            <script>
                // Muaz Khan     - www.MuazKhan.com
                // MIT License   - www.WebRTC-Experiment.com/licence
                // Documentation - www.RTCMultiConnection.org

                var connection = new RTCMultiConnection();

                // https://github.com/muaz-khan/WebRTC-Experiment/tree/master/socketio-over-nodejs
                var SIGNALING_SERVER = 'https://webrtcweb.com:9559/';
                connection.openSignalingChannel = function(config) {
                    var channel = config.channel || connection.channel || 'default-namespace';
                    var sender = Math.round(Math.random() * 9999999999) + 9999999999;

                    io.connect(SIGNALING_SERVER).emit('new-channel', {
                        channel: channel,
                        sender: sender
                    });

                    var socket = io.connect(SIGNALING_SERVER + channel);
                    socket.channel = channel;

                    socket.on('connect', function() {
                        if (config.callback) config.callback(socket);
                    });

                    socket.send = function(message) {
                        socket.emit('message', {
                            sender: sender,
                            data: message
                        });
                    };

                    socket.on('message', config.onmessage);
                };

                connection.session = {
                    audio: true
                };
                
                // using HD-stereo-audio
                connection.processSdp = function(sdp) {
                    sdp = addStereo(sdp);
                    return sdp;
                };

                function addStereo(sdp) {
                  var sdpLines = sdp.split('\r\n');

                  // Find opus payload.
                  var opusIndex = findLine(sdpLines, 'a=rtpmap', 'opus/48000');
                  var opusPayload;
                  if (opusIndex) {
                    opusPayload = getCodecPayloadType(sdpLines[opusIndex]);
                  }

                  // Find the payload in fmtp line.
                  var fmtpLineIndex = findLine(sdpLines, 'a=fmtp:' + opusPayload.toString());
                  if (fmtpLineIndex === null) {
                    return sdp;
                  }

                  // Append stereo=1 to fmtp line.
                  sdpLines[fmtpLineIndex] = sdpLines[fmtpLineIndex].concat('; stereo=1; maxaveragebitrate=' + (128 * 1024));

                  sdp = sdpLines.join('\r\n');
                  return sdp;
                }

                // Find the line in sdpLines that starts with |prefix|, and, if specified,
                // contains |substr| (case-insensitive search).
                function findLine(sdpLines, prefix, substr) {
                  return findLineInRange(sdpLines, 0, -1, prefix, substr);
                }

                // Find the line in sdpLines[startLine...endLine - 1] that starts with |prefix|
                // and, if specified, contains |substr| (case-insensitive search).
                function findLineInRange(sdpLines, startLine, endLine, prefix, substr) {
                  var realEndLine = endLine !== -1 ? endLine : sdpLines.length;
                  for (var i = startLine; i < realEndLine; ++i) {
                    if (sdpLines[i].indexOf(prefix) === 0) {
                      if (!substr ||
                          sdpLines[i].toLowerCase().indexOf(substr.toLowerCase()) !== -1) {
                        return i;
                      }
                    }
                  }
                  return null;
                }

                // Gets the codec payload type from an a=rtpmap:X line.
                function getCodecPayloadType(sdpLine) {
                  var pattern = new RegExp('a=rtpmap:(\\d+) \\w+\\/\\d+');
                  var result = sdpLine.match(pattern);
                  return (result && result.length === 2) ? result[1] : null;
                }

                var roomsList = document.getElementById('rooms-list'), sessions = { };
                connection.onNewSession = function(session) {
                    if (sessions[session.sessionid]) return;
                    sessions[session.sessionid] = session;

                    var tr = document.createElement('tr');
                    tr.innerHTML = '<td><strong>' + ((session.extra && session.extra['user-name']) || session.userid) + '</strong> is making an audio call.</td>' +
                        '<td><button class="join" id="receive-call">Receive Call</button></td>';
                    roomsList.insertBefore(tr, roomsList.firstChild);

                    tr.querySelector('#receive-call').setAttribute('data-sessionid', session.sessionid);
                    tr.querySelector('#receive-call').onclick = function() {
                        this.disabled = true;

                        session = sessions[this.getAttribute('data-sessionid')];
                        if (!session) alert('No room to join.');

                        connection.join(session);
                    };
                };

                var audiosContainer = document.getElementById('audios-container') || document.body;
                connection.onstream = function(e) {
					var audioElement = getAudioElement(e.mediaElement, {
						title: (e.extra && e.extra['user-name']) || e.userid,
						onMuted: function(type) {
                            connection.streams[e.streamid].mute({
                                audio: type == 'audio',
                                video: type == 'video'
                            });
                        },
                        onUnMuted: function(type) {
                            connection.streams[e.streamid].unmute({
                                audio: type == 'audio',
                                video: type == 'video'
                            });
                        },
                        onRecordingStarted: function(type) {
                            connection.streams[e.streamid].startRecording({
                                audio: type == 'audio',
                                video: type == 'video'
                            });
                        },
                        onRecordingStopped: function(type) {
                            connection.streams[e.streamid].stopRecording(function(blob) {
                                var _mediaElement = document.createElement(type);
                                
                                _mediaElement.src = URL.createObjectURL(blob);
                                _mediaElement = getMediaElement(_mediaElement, {
                                    buttons: ['mute-audio', 'mute-video', 'stop']
                                });
                                
                                _mediaElement.toggle(['mute-audio', 'mute-video']);
                                
                                audiosContainer.insertBefore(_mediaElement, audiosContainer.firstChild);
                            }, type);
                        },
                        onStopped: function() {
                            connection.drop();
                        }
					});
					
					if(e.type == 'local') {
						// audioElement.toggle('mute-audio');
                        e.mediaElement.volume = 0;
                        e.mediaElement.muted = true;
					}
					
                    audiosContainer.insertBefore(audioElement, audiosContainer.firstChild);
                };

                connection.onstreamended = function(e) {
                    if (e.mediaElement.parentNode && e.mediaElement.parentNode.parentNode && e.mediaElement.parentNode.parentNode.parentNode) {
                        e.mediaElement.parentNode.parentNode.parentNode.removeChild(e.mediaElement.parentNode.parentNode);
                    }
                };
				
				document.getElementById('user-name').onkeyup = function() {
					connection.extra['user-name'] = this.value;
				};

                document.getElementById('setup-voice-only-call').onclick = function() {
                    this.disabled = true;
                    connection.open();
                };
                
                connection.extra = {
                    'user-name': 'Anonymous'
                };

                connection.connect();
				
				(function() {
                    var uniqueToken = document.getElementById('unique-token');
                    if (uniqueToken)
                        if (location.hash.length > 2) uniqueToken.parentNode.parentNode.parentNode.innerHTML = '<h2 style="text-align:center;"><a href="' + location.href + '" target="_blank">Share this link</a></h2>';
                        else uniqueToken.innerHTML = uniqueToken.parentNode.parentNode.href = '#' + (Math.random() * new Date().getTime()).toString(36).toUpperCase().replace( /\./g , '-');
                })();
            </script>
            
            <section class="experiment">
                <h2 class="header">How to setup <a href="http://www.RTCMultiConnection.org/docs/" target="_blank">voice-only</a> call?</h2>
                
                <pre>
// https://cdn.webrtc-experiment.com/RTCMultiConnection.js

var connection = new RTCMultiConnection();
connection.session = {
    audio: true
};
connection.connect();
btnStartVoiceOnlyCall.onclick = function() {
    connection.open();
};
</pre>
            </section>
            
            <section class="experiment">
                <h2 class="header" id="feedback">Feedback</h2>
                <div>
                    <textarea id="message" style="border: 1px solid rgb(189, 189, 189); height: 8em; margin: .2em; outline: none; resize: vertical; width: 98%;" placeholder="Have any message? Suggestions or something went wrong?"></textarea>
                </div>
                <button id="send-message" style="font-size: 1em;">Send Message</button><small style="margin-left: 1em;">Enter your email too; if you want "direct" reply!</small>
            </section>
            
            <section class="experiment own-widgets latest-commits">
                <h2 class="header" id="updates" style="color: red; padding-bottom: .1em;"><a href="https://github.com/muaz-khan/WebRTC-Experiment/commits/master" target="_blank">Latest Updates</a></h2>
                <div id="github-commits"></div>
            </section>
            
        </article>

        <a href="https://github.com/muaz-khan/RTCMultiConnection" class="fork-left"></a>
	
        <footer>
            <a href="https://www.webrtc-experiment.com/" target="_blank">WebRTC Experiments!</a> and 
            <a href="http://www.RTCMultiConnection.org/docs/" target="_blank">RTCMultiConnection.js</a> ©
            <a href="mailto:muazkh@gmail.com" target="_blank">Muaz Khan</a>:
            <a href="https://twitter.com/WebRTCWeb" target="_blank">@WebRTCWeb</a>
        </footer>
    
        <!-- commits.js is useless for you! -->
        <script>window.useThisGithubPath = 'muaz-khan/RTCMultiConnection';</script>
        <script src="https://cdn.webrtc-experiment.com/commits.js" async></script>
    </body>
</html>
