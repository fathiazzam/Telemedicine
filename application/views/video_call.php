<div class="jumbotron" data-spy="affix" style="background-color: #00a400;">
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div id="videos" class="bg-light box-shadow" style="width: 100%; height: 100%;">
          <video id="remoteVideo" autoplay playsinline></video>
          <div class="overlay">
            <video id="localVideo" autoplay playsinline width="20%" height="20%" style="left:0;"></video>
          </div>               
        </div>                                
      </div>
      <div class="col-sm-3">
        <div class="container">
          <div class="list-group-item list-group-item-action active" style="background-color: #134B4B;">Online</div> 
          <div id="online" class="list-group">          
          </div>
        </div>
      </div>
    </div>
    <button id="cancel2" class="btn btn-default">Cancel</button>
  </div> 
</div>

    <style>
      .overlay {
          position:absolute;
          top:0;
          left:0;
          z-index:1;
      }
      .volume {
          position: absolute;
          right: 17%;
          width: 20%;
          bottom: 2px;
          height: 10px;
      }
    </style>