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
					  rel: 0,
					  modestbranding: true,
					  controls: 0
				}
		  });
		};

		// 4. The API will call this function when the video player is ready.
		window.onPlayerReady = function(event) {
			// cue the playlist, to get the video's ids 
		    console.log("onPlayerReady event triggered: CUE Playlist");
			window.player.cuePlaylist
		    ({
		        listType: 'playlist',
		        list: window.playlist_id,
		        autoplay: 1,
		        index:0,
		    });   
		};

		// 5. The API calls this function when the player's state changes.
		
		window.onPlayerStateChange = function(event) {
			
			console.log("onPlayerStateChange event triggered with event type: " + event.data);
			if(event.data == YT.PlayerState.CUED)
		    {
				
				var videoList = window.player.getPlaylist();
		        // to prevent adding new video and for the randomize
		        if( typeof videoList == 'undefined' || videoList == "" ){
		        	console.warn("onPlayerStateChange: Failed to get playlist! Reloading...");
		        	window.player.loadPlaylist({
						listType: 'playlist',
						list: window.playlist_id,
		        		
		        	});
		        	videoList = window.player.getPlaylist();
		        	
		        }
				window.videoCount = videoList.length; 
		        console.log("onPlayerStateChange: List of all videos in playlist: " + videoList + ":" + window.videoCount);
		        // starting playing the playlist from random item
		        var num = getRandom(0,window.videoCount - 1);
		        window.player.playVideoAt(num);
		    }

			
		    if(event.data == YT.PlayerState.ENDED)	
		    {
				window.videoCount--;
		        console.log("Video ended. " + window.videoCount + " Items left in playlist");
		    	if (window.videoCount <= 0){
		        	console.log("Playlist ended. Loading a new one...");
		        	loadNewPlaylist(event);
		        }
				window.player.nextVideo();
		    }
		};
		
		function loadNewPlaylist(event) {
			var playlists = $(".tube_thumbs");
			var playlist_id = $(playlists[Math.floor(Math.random() * playlists.length)]).attr('id'); // getting random playlist from playlists lists
			var total_items = getPlaylistItemsNumber(playlist_id);
			console.log('loadNewPlaylist: Playlist selected ' + playlist_id + ' with total items: ' + total_items);
			//window.player.stopVideo();
			var random_video_num = getRandom(0, total_items);
			window.videoCount = total_items -random_video_num;
			window.player.cuePlaylist({
				list: playlist_id,
				listType: 'playlist',
				autoplay: 1,
				index: random_video_num,
				});
		}
			
		$(".tube_thumbs").click(function(){
			var playlist_id = $(this).attr("id");
			console.log(playlist_id);
			console.log('Playlist selected from sidebar: ' + playlist_id);
			window.player.cuePlaylist({
				list: 		playlist_id,
				listType:   'playlist',
		        autoplay: 	1,
		        index:	0
			});
//			var videoList = window.player.getPlaylist();
//			// to prevent adding new video and for the randomize
//			window.videoCount = videoList.length; 
//			console.log("Sidebar: List of all videos in playlist: " + videoList);
		});
		
		function getRandom(min, max) {
			  return Math.floor(Math.random() * (max - min + 1)) + min;
			}
	
	  function getPlaylistItemsNumber(pid){ 
		  var result = null;  
		  $.ajax({
					url: "https://www.googleapis.com/youtube/v3/playlistItems",
					type: 'get',
					dataType: 'json',
					async:	false,
					data: {
								part : 'snippet', 
								maxResults : 2,
								playlistId : pid,
								//fields: 'pageInfo(totalResults)',        
								key: 'AIzaSyAi1i-MN1M-jiSzV1y2qTydlHmM4ZFwjJY', 
							},
					success:	function(data) {
									 window.total = data.pageInfo.totalResults;
									 console.log("Total items: " + window.total);
									 result = data;
				//			             $('#total').html('Total number of clips: ' + total);
				//			             st = JSON.stringify(data,'',2);
				//			             $('#area1').val(st);
								}
		  });
		  return result.pageInfo.totalResults;
	  	}
	});
})( jQuery );
