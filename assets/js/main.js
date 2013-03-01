var access_token = '240976113.4d307df.e0a133edcba44ec885c5c17ce4215b1f';
var end_point = 'https://api.instagram.com/v1/';

function build_box(src, caption)
{
    var text = '';
    if (caption)
    {
        text = caption.text
    }
    var img = $('<img src="'+src+'" title="'+text+'" alt="'+text+'"/>');
    var caption_div = $('<div class="caption">'+text+'</div>');
    
    return $('<div class="box"></div>').append(img).append(caption_div).bind('mouseenter', function() {
        caption_div.fadeIn();
    }).bind('mouseleave', function() {
        caption_div.fadeOut();
    });
}

function create_spin()
{
    var opts = {
        lines: 13, // The number of lines to draw
        length: 7, // The length of each line
        width: 3, // The line thickness
        radius: 15, // The radius of the inner circle
        corners: 1, // Corner roundness (0..1)
        rotate: 0, // The rotation offset
        color: '#000', // #rgb or #rrggbb
        speed: 1, // Rounds per second
        trail: 60, // Afterglow percentage
        shadow: true, // Whether to render a shadow
        hwaccel: true, // Whether to use hardware acceleration
        className: 'spinner', // The CSS class to assign to the spinner
        zIndex: 2e9, // The z-index (defaults to 2000000000)
        top: 'auto', // Top position relative to parent in px
        left: 'auto' // Left position relative to parent in px
    };
    var target = document.getElementById('container');
    var spinner = new Spinner(opts).spin(target);
    return spinner;
}

function wp_instagram_wall()
{
    // Spinner
    var spinner = create_spin();
    
    // Manonsy
    var $container = $('#container');
    $container.masonry({
        itemSelector : '.box',
        columnWidth: 306,
        gutterWidth: 5,
        isAnimated: true,
    });
    
    var stream = Array();
    
    $container.bind('streamcreated', function(event) {
        spinner.stop();
        for (index in stream)
        {
            var data = stream[index];
            console.log(data);
            var box = build_box(data.data.images.low_resolution.url, 
                    data.data.caption);
            if (index == 0)
                box = build_box(data.data.images.standard_resolution.url,
                        data.data.caption);
            
            $container.append(box).imagesLoaded( function() {
                $container.masonry('appended', box);
                $container.masonry('reload');
            });
        }

        
    });

    // AJAX photos
    
    $.ajax({
        url : end_point + 'users/self/media/recent?access_token=' + access_token+'&max_timestamp=0',
        dataType: "jsonp"
    }).done(function(response) {
        var count = 0;
        for (photo_index in response.data)
        {
            var photo = response.data[photo_index];
            $.ajax({
                url : end_point + 'media/' + photo.id + '?access_token=' + access_token,
                dataType: "jsonp"
            }).done(function(data) {
                stream.push(data);
                if (count == response.data.length - 1)
                    $container.trigger('streamcreated');
                count++;
            })
        }
        
    });
    
}