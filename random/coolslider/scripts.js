jQuery.easing.jswing = jQuery.easing.swing;
jQuery.extend(jQuery.easing, {
    def: "easeOutQuad",
    swing: function (e, f, a, h, g) {
        return jQuery.easing[jQuery.easing.def](e, f, a, h, g)
    },
    easeInQuad: function (e, f, a, h, g) {
        return h * (f /= g) * f + a
    },
    easeOutQuad: function (e, f, a, h, g) {
        return -h * (f /= g) * (f - 2) + a
    },
    easeInOutQuad: function (e, f, a, h, g) {
        if ((f /= g / 2) < 1) {
            return h / 2 * f * f + a
        }
        return -h / 2 * ((--f) * (f - 2) - 1) + a
    },
    easeInCubic: function (e, f, a, h, g) {
        return h * (f /= g) * f * f + a
    },
    easeOutCubic: function (e, f, a, h, g) {
        return h * ((f = f / g - 1) * f * f + 1) + a
    },
    easeInOutCubic: function (e, f, a, h, g) {
        if ((f /= g / 2) < 1) {
            return h / 2 * f * f * f + a
        }
        return h / 2 * ((f -= 2) * f * f + 2) + a
    },
    easeInQuart: function (e, f, a, h, g) {
        return h * (f /= g) * f * f * f + a
    },
    easeOutQuart: function (e, f, a, h, g) {
        return -h * ((f = f / g - 1) * f * f * f - 1) + a
    },
    easeInOutQuart: function (e, f, a, h, g) {
        if ((f /= g / 2) < 1) {
            return h / 2 * f * f * f * f + a
        }
        return -h / 2 * ((f -= 2) * f * f * f - 2) + a
    },
    easeInQuint: function (e, f, a, h, g) {
        return h * (f /= g) * f * f * f * f + a
    },
    easeOutQuint: function (e, f, a, h, g) {
        return h * ((f = f / g - 1) * f * f * f * f + 1) + a
    },
    easeInOutQuint: function (e, f, a, h, g) {
        if ((f /= g / 2) < 1) {
            return h / 2 * f * f * f * f * f + a
        }
        return h / 2 * ((f -= 2) * f * f * f * f + 2) + a
    },
    easeInSine: function (e, f, a, h, g) {
        return -h * Math.cos(f / g * (Math.PI / 2)) + h + a
    },
    easeOutSine: function (e, f, a, h, g) {
        return h * Math.sin(f / g * (Math.PI / 2)) + a
    },
    easeInOutSine: function (e, f, a, h, g) {
        return -h / 2 * (Math.cos(Math.PI * f / g) - 1) + a
    },
    easeInExpo: function (e, f, a, h, g) {
        return (f == 0) ? a : h * Math.pow(2, 10 * (f / g - 1)) + a
    },
    easeOutExpo: function (e, f, a, h, g) {
        return (f == g) ? a + h : h * (-Math.pow(2, - 10 * f / g) + 1) + a
    },
    easeInOutExpo: function (e, f, a, h, g) {
        if (f == 0) {
            return a
        }
        if (f == g) {
            return a + h
        }
        if ((f /= g / 2) < 1) {
            return h / 2 * Math.pow(2, 10 * (f - 1)) + a
        }
        return h / 2 * (-Math.pow(2, - 10 * --f) + 2) + a
    },
    easeInCirc: function (e, f, a, h, g) {
        return -h * (Math.sqrt(1 - (f /= g) * f) - 1) + a
    },
    easeOutCirc: function (e, f, a, h, g) {
        return h * Math.sqrt(1 - (f = f / g - 1) * f) + a
    },
    easeInOutCirc: function (e, f, a, h, g) {
        if ((f /= g / 2) < 1) {
            return -h / 2 * (Math.sqrt(1 - f * f) - 1) + a
        }
        return h / 2 * (Math.sqrt(1 - (f -= 2) * f) + 1) + a
    },
    easeInElastic: function (f, h, e, l, k) {
        var i = 1.70158;
        var j = 0;
        var g = l;
        if (h == 0) {
            return e
        }
        if ((h /= k) == 1) {
            return e + l
        }
        if (!j) {
            j = k * 0.3
        }
        if (g < Math.abs(l)) {
            g = l;
            var i = j / 4
        } else {
            var i = j / (2 * Math.PI) * Math.asin(l / g)
        }
        return -(g * Math.pow(2, 10 * (h -= 1)) * Math.sin((h * k - i) * (2 * Math.PI) / j)) + e
    },
    easeOutElastic: function (f, h, e, l, k) {
        var i = 1.70158;
        var j = 0;
        var g = l;
        if (h == 0) {
            return e
        }
        if ((h /= k) == 1) {
            return e + l
        }
        if (!j) {
            j = k * 0.3
        }
        if (g < Math.abs(l)) {
            g = l;
            var i = j / 4
        } else {
            var i = j / (2 * Math.PI) * Math.asin(l / g)
        }
        return g * Math.pow(2, - 10 * h) * Math.sin((h * k - i) * (2 * Math.PI) / j) + l + e
    },
    easeInOutElastic: function (f, h, e, l, k) {
        var i = 1.70158;
        var j = 0;
        var g = l;
        if (h == 0) {
            return e
        }
        if ((h /= k / 2) == 2) {
            return e + l
        }
        if (!j) {
            j = k * (0.3 * 1.5)
        }
        if (g < Math.abs(l)) {
            g = l;
            var i = j / 4
        } else {
            var i = j / (2 * Math.PI) * Math.asin(l / g)
        }
        if (h < 1) {
            return -0.5 * (g * Math.pow(2, 10 * (h -= 1)) * Math.sin((h * k - i) * (2 * Math.PI) / j)) + e
        }
        return g * Math.pow(2, - 10 * (h -= 1)) * Math.sin((h * k - i) * (2 * Math.PI) / j) * 0.5 + l + e
    },
    easeInBack: function (e, f, a, i, h, g) {
        if (g == undefined) {
            g = 1.70158
        }
        return i * (f /= h) * f * ((g + 1) * f - g) + a
    },
    easeOutBack: function (e, f, a, i, h, g) {
        if (g == undefined) {
            g = 0.70158
        }
        return i * ((f = f / h - 1) * f * ((g + 1) * f + g) + 1) + a
    },
    easeInOutBack: function (e, f, a, i, h, g) {
        if (g == undefined) {
            g = 1.70158
        }
        if ((f /= h / 2) < 1) {
            return i / 2 * (f * f * (((g *= (1.525)) + 1) * f - g)) + a
        }
        return i / 2 * ((f -= 2) * f * (((g *= (1.525)) + 1) * f + g) + 2) + a
    },
    easeInBounce: function (e, f, a, h, g) {
        return h - jQuery.easing.easeOutBounce(e, g - f, 0, h, g) + a
    },
    easeOutBounce: function (e, f, a, h, g) {
        if ((f /= g) < (1 / 2.75)) {
            return h * (7.5625 * f * f) + a
        } else {
            if (f < (2 / 2.75)) {
                return h * (7.5625 * (f -= (1.5 / 2.75)) * f + 0.75) + a
            } else {
                if (f < (2.5 / 2.75)) {
                    return h * (7.5625 * (f -= (2.25 / 2.75)) * f + 0.9375) + a
                } else {
                    return h * (7.5625 * (f -= (2.625 / 2.75)) * f + 0.984375) + a
                }
            }
        }
    },
    easeInOutBounce: function (e, f, a, h, g) {
        if (f < g / 2) {
            return jQuery.easing.easeInBounce(e, f * 2, 0, h, g) * 0.5 + a
        }
        return jQuery.easing.easeOutBounce(e, f * 2 - g, 0, h, g) * 0.5 + h * 0.5 + a
    }
});

(function (c, n) {
    var k = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
    c.fn.imagesLoaded = function (l) {
        function m() {
            var b = c(h),
                a = c(g);
            d && (g.length ? d.reject(e, b, a) : d.resolve(e));
            c.isFunction(l) && l.call(f, e, b, a)
        }
        function i(b, a) {
            b.src === k || -1 !== c.inArray(b, j) || (j.push(b), a ? g.push(b) : h.push(b), c.data(b, "imagesLoaded", {
                isBroken: a,
                src: b.src
            }), o && d.notifyWith(c(b), [a, e, c(h), c(g)]), e.length === j.length && (setTimeout(m), e.unbind(".imagesLoaded")))
        }
        var f = this,
            d = c.isFunction(c.Deferred) ? c.Deferred() : 0,
            o = c.isFunction(d.notify),
            e = f.find("img").add(f.filter("img")),
            j = [],
            h = [],
            g = [];
        e.length ? e.bind("load.imagesLoaded error.imagesLoaded", function (b) {
            i(b.target, "error" === b.type)
        }).each(function (b, a) {
            var e = a.src,
                d = c.data(a, "imagesLoaded");
            if (d && d.src === e) i(a, d.isBroken);
            else if (a.complete && a.naturalWidth !== n) i(a, 0 === a.naturalWidth || 0 === a.naturalHeight);
            else if (a.readyState || a.complete) a.src = k, a.src = e
        }) : m();
        return d ? d.promise(f) : f
    }
})(jQuery);


var center = $(window).width()/2;
    
$(document).ready(function() {

    function updateSlidePos() {
        $('.slide.active img').each(function(){
            var posleft = parseInt($(this).attr('class').split(' ')[1].replace("left", ""));
            var pos = posleft + center;
            var top = parseInt($(this).attr('class').split(' ')[4].replace("t", ""));
            var order = parseInt($(this).attr('class').split(' ')[5].replace("z", ""));
            if($(this).hasClass('fade')){
                $(this).css({'left': pos, 'top': top, 'z-index':order});
            } else {
                $(this).css({'left': pos, 'top': top, 'z-index':order}).show();
            }
        }); 
        setTimeout(function(){
            $('.slide.active img.fade,.slide.active .info').fadeIn(600, 'easeInOutQuad',function(){
                $('#feature').removeClass();
            });
        },800); 
    }

    //SLIDES
    function slides() {
        
        //PAGINATION
        $('#feature').addClass('disabled').append('<ul id="pagination" /><a href="" id="slide-left" /><a href="" id="slide-right" />')
        $('#feature article').each(function(){
            $('#pagination').append('<li><a href="#'+ $(this).attr('id') +'">'+ $(this).index() +'</a></li>');
        });
        $('#pagination li:first').addClass('active');
        $('#pagination').css({'left':($(window).width()-$('#pagination li').length*14)/2});
        var left = 0;
        
        function showSlide() {
            $('.slide.active img').each(function(){
                var posleft = parseInt($(this).attr('class').split(' ')[1].replace("left", ""));
                var pos = posleft + center;
                var start = parseInt($(this).attr('class').split(' ')[2].replace("st", ""));
                var speed = parseInt($(this).attr('class').split(' ')[3].replace("sp", ""));
                var top = parseInt($(this).attr('class').split(' ')[4].replace("t", ""));
                var order = parseInt($(this).attr('class').split(' ')[5].replace("z", ""));
                if($(this).hasClass('fade')){
                    $(this).css({'left': pos, 'top': top, 'z-index':order});
                } else {
                    if($('#feature').hasClass('scrollLeft')) {
                        var side = -$(this).width() - start;
                    } else {
                        var side = $(window).width() + start;
                    }
                    $(this).css({'left': side, 'top': top, 'z-index':order}).show();
                    $(this).animate({'left':pos},speed,'easeOutQuad');
                }
            });
            setTimeout(function(){
                $('.slide.active img.fade,.slide.active .info').fadeIn(600, 'easeInOutQuad',function(){
                    $('#feature').removeClass();
                });
            },1000);
        }
        
        function nextSlide() {
            $('.slide.active').removeClass('active').addClass('previous');
            $('.slide.previous img').not('.fade').each(function(){
                var outstart = parseInt($(this).attr('class').split(' ')[2].replace("st", ""));
                var outspeed = parseInt($(this).attr('class').split(' ')[3].replace("sp", ""));
                if($('#feature').hasClass('scrollLeft')) {
                    $(this).animate({'left': $(window).width() + outstart},outspeed,'easeInQuad');
                } else {
                    $(this).animate({'left': -$(this).width()-outstart},outspeed,'easeInQuad');
                }
            });
            $('.slide.previous img.fade,.slide.previous .info').fadeOut(600, 'easeInQuad', function(){
                $('.slide.next').removeClass('next').addClass('active').fadeIn(1000, 'easeInOutQuad', function(){
                    $('.slide.previous').removeClass('previous').fadeOut(1000, 'easeInOutQuad');
                    showSlide();
                });
            });
        }
        
        $('.slide:first').addClass('active').fadeIn(1000, 'easeInOutQuad', function(){
            $('#slide-left, #slide-right, #pagination').fadeIn(300, 'easeInOutQuad',function(){
                showSlide();
            });     
        });
        
        //PAGINATION
        $('#pagination li').not('active').click(function(){
            clearInterval(autoplay);
            if($(this).index() < $('#pagination li.active').index()) {
                $('#feature').addClass('scrollLeft');               
            }
            if(!$('#feature').hasClass('disabled')) {               
                $('#feature').addClass('disabled');
                $('#pagination li.active').removeClass();
                $(this).addClass('active');
                $($(this).find('a').attr('href')).addClass('next');
                nextSlide();
            }
            return false;
        });
        
        //LEFT/RIGHT
        $('#slide-left').click(function(){
            clearInterval(autoplay);
            if(!$('#feature').hasClass('disabled')) {           
                $('#feature').addClass('disabled');
                if($('#pagination li:first').hasClass('active')) {
                    $('#pagination li.active').removeClass();
                    $('#pagination li:last').addClass('active');
                    $('#feature article:last').addClass('next');
                } else {
                    $('#pagination li.active').removeClass().prev().addClass('active');
                    $('#feature article.active').prev().addClass('next');
                }
                $('#feature').addClass('scrollLeft');
                nextSlide();
            }
            return false;
        });
        
        function slideRight() {
            if(!$('#feature').hasClass('disabled')) {           
                $('#feature').addClass('disabled');
                if($('#pagination li:last').hasClass('active')) {
                    $('#pagination li.active').removeClass();
                    $('#pagination li:first').addClass('active');
                    $('#feature article:first').addClass('next');
                } else {
                    $('#pagination li.active').removeClass().next().addClass('active');
                    $('#feature article.active').next().addClass('next');
                }
                nextSlide();
            }
        }
        
        $('#slide-right').click(function(){
            clearInterval(autoplay);
            slideRight();
            return false;
        });
        
        var autoplay = setInterval(function(){
            slideRight()
        },10000);       
    }
    
    $(window).load(function() {
        if($(window).width() > 767) {
            $.ajax({
                url: "banner.php",
                type: "POST",
                dataType: 'html',
                success: function(data){
                    $('#feature h1').after(data);
                    $('#feature img').imagesLoaded(
                        function($images,$proper,$broken) {
                            setTimeout(function(){
                                slides();                           
                            },1000);
                        }
                    );          
                }
             });
        }
    });
    
    $(window).resize(function(){
        $('#pagination').css({'left':($(window).width()-$('#pagination li').length*14)/2});
        center = $(window).width()/2;
        updateSlidePos();
    });


});