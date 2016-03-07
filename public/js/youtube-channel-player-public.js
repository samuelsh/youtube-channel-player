(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
	$(window).load( function() {
		
		window.player = null;
		window.playlists = "";
		window.playlist_id = 0;
		window.videoList = "";
		window.videoCount = 0;
		
		// 2. This code loads the IFrame Player API code asynchronously.
		$.getScript("https://www.youtube.com/iframe_api", function( data, textStatus, jqxhr ) {
			  console.log( data ); // Data returned
			  console.log( textStatus ); // Success
			  console.log( jqxhr.status ); // 200
		});		
		
		// 3. This function creates an <iframe> (and YouTube player)
		//    after the API code downloads.
		window.onYouTubeIframeAPIReady = function() {
			var playlists = $(".tube_thumbs");
			window.playlist_id = $(playlists[Math.floor(Math.random() * playlists.length)]).attr('id'); // getting random playlist from playlists lists
			console.log('Playlist selected ' + playlist_id);
			window.player = new YT.Player('inner_tube', {
				height: '380',
				width: '320',
				events: {
				  'onReady': window.onPlayerReady,
				  'onStateChange': window.onPlayerStateChange
				},
				playerVars: {
//					  list: playlist_id,
//					  listType: 'playlist'
				}
		  });
		};

		// 4. The API will call this function when the video player is ready.
		window.onPlayerReady = function(event) {
			// cue the playlist, to get the video's ids 
		    event.target.cuePlaylist
		    ({
		        listType: 'playlist',
		        list: window.playlist_id,
		        autoplay: 1,
		        index:0,
		    });   
		};

		// 5. The API calls this function when the player's state changes.
		
		window.onPlayerStateChange = function(event) {
			if(event.data == YT.PlayerState.CUED)
		    {
		        var videoList = window.player.getPlaylist();
		        // to prevent adding new video and for the randomize
		        window.videoCount = videoList.length; 
		        console.log("onPlayerStateChange: List of all videos in playlist: " + videoList);
		        // starting playing the playlist from random item
		        var num = getRandom(1,window.videoCount);
		        window.player.playVideo();
		    }

//			if(event.data == YT.PlayerState.PLAYING)
//		    {
//		        var videoList = window.player.getPlaylist();
//		        // to prevent adding new video and for the randomize
//		        window.videoCount = videoList.length; 
//		        console.log("onPlayerStateChange: List of all videos in playlist: " + videoList);
//		        // starting playing the playlist from random item
//		        var num = getRandom(1,window.videoCount);
//		    }
			
		    if(event.data == YT.PlayerState.ENDED)	
		    {
		        if (window.videoCount == 0){
		        	console.log("Playlist ended. Loading a new one...");
		        	loadNewPlaylist();
		        }
		        
		        else {
		        	window.videoCount--;
		        	event.target.nextVideo();
		        }
		    }
		};
		
		function loadNewPlaylist() {
			window.player.stopVideo();
			var playlists = $(".tube_thumbs");
			var playlist_id = $(playlists[Math.floor(Math.random() * playlists.length)]).attr('id'); // getting random playlist from playlists lists
			console.log('loadNewPlaylist: Playlist selected ' + playlist_id);
			window.player.cuePlaylist({
				list: playlist_id
				});
		}
			
		$(".tube_thumbs").click(function(){
			var playlist_id = $(this).attr("id");
			console.log(playlist_id);
			console.log('Playlist selected from sidebar: ' + playlist_id);
			window.player.cuePlaylist({
				list: playlist_id
				});
//			var videoList = window.player.getPlaylist();
//			// to prevent adding new video and for the randomize
//			window.videoCount = videoList.length; 
//			console.log("Sidebar: List of all videos in playlist: " + videoList);
		});
		
		function getRandom(min, max) {
			  return Math.floor(Math.random() * (max - min + 1)) + min;
			}
	});
})( jQuery );
