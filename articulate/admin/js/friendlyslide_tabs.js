(function ($) {
    $.fn.friendlySlideTabs = function (b) {
        var c = {
            tabsList: 'ul.tabs',
            viewContainer: 'div.view_container',
            btnNext: 'a.next',
            btnPrev: 'a.prev',
            tabClass: 'tab',
            tabActiveClass: 'active',
            viewActiveClass: 'active_view',
            btnDisabledClass: 'disabled',
            orientation: 'horizontal',
            slideLength: 694,
            offsetTL: 0,
            offsetBR: 0,
            tabsEasing: '',
            tabsAnimTime: 300,
            tabsScroll: true,
            tabSaveState: false,
            contentAnim: 'slideH',
            contentEasing: 'easeInOutExpo',
            contentAnimTime: 600,
            autoHeight: false,
            autoHeightTime: 0
        },
            conf = $.extend(true, {}, c, b);
        return this.each(function () {
            var a = new friendlySlideTabs($(this), conf);
            a.init()
        })
    };

    function friendlySlideTabs(d, e) {
        var f = d.find(e.tabsList),
            $content = d.find(e.viewContainer).css('overflow', 'hidden'),
            $prev = d.find(e.btnPrev).click(function () {
                g.prevTab(val);
                return false
            }),
            $next = d.find(e.btnNext).click(function () {
                g.nextTab(val);
                return false
            }),
            $tab, $activeTab, $elem, $lastElem, $view, $activeView, val = {},
            elemMargin = 0;
        this.init = function () {
            if (e.orientation == 'horizontal') {
                val.func = 'outerWidth';
                val.obj = 'left';
                val.attr = 'marginLeft'
            } else {
                val.func = 'outerHeight';
                val.obj = 'top';
                val.attr = 'marginTop'
            }
            g.posActiveTab();
            g.bindEvents()
        };
        var g = {
            tabsAnim: '#' + d.attr('id') + ' ' + e.tabsList + ':animated',
            bindEvents: function () {
                f.delegate('li a.' + e.tabClass, 'click', function () {
                    g.tabClick(this);
                    return false
                });
                if (e.tabsScroll == true) {
                    f.mousewheel(function (a, b) {
                        (b > 0) ? g.prevTab(val) : g.nextTab(val);
                        return false
                    })
                }
            },
            posActiveTab: function () {
                g.getActive();
                content.showActiveContent();
                $lastElem = f.children('li:last');
                $activeTab = $activeTab.parent('li');
                if (($lastElem[val.func](true) + $lastElem.position()[val.obj]) > e.slideLength) {
                    val.elemD = $activeTab[val.func](true);
                    val.elemP = $activeTab.position()[val.obj];
                    if (val.elemP > e.slideLength) {
                        elemMargin += (val.elemD + (val.elemP - e.slideLength));
                        elemMargin = (elemMargin + e.offsetBR)
                    } else if ((val.elemP + val.elemD) > e.slideLength) {
                        elemMargin += (val.elemD - (e.slideLength - val.elemP));
                        elemMargin = (elemMargin + e.offsetBR)
                    } else {
                        elemMargin = (elemMargin - e.offsetTL)
                    }
                    f.css(val.attr, -+elemMargin);
                    g.showTabButtons()
                }
            },
            showTabButtons: function () {
                if (f.children('li:first').position()[val.obj] == (0 + e.offsetTL)) {
                    $prev.addClass(e.btnDisabledClass)
                } else if (($lastElem.position()[val.obj] + $lastElem[val.func](true)) == (e.slideLength - e.offsetBR)) {
                    $next.addClass(e.btnDisabledClass)
                }
                $prev.show();
                $next.show()
            },
            tabClick: function (a) {
                $tab = $(a);
                if ($(content.contAnim).length || $tab.hasClass(e.tabActiveClass)) {
                    return false
                }
                $elem = $tab.parent('li');
                g.setActive();
                val.elemP = $elem.position();
                val.activeElemP = $activeTab.position();
                g.slideClicked(val);
                $activeView = $content.children('div.' + e.viewActiveClass).removeClass(e.viewActiveClass);
                $view = $content.children('div#' + $tab.attr('hash')).addClass(e.viewActiveClass);
                if (e.autoHeight == true) {
                    content.adjustHeight()
                }
                if (e.contentAnim.length > 0) {
                    content[e.contentAnim](val)
                } else {
                    $activeView.hide();
                    $view.show()
                }
            },
            getActive: function () {
                if ($.cookie) {
                    var a = $.cookie(d.attr('id'))
                }
                if (a) {
                    f.children('li').find('.' + e.tabActiveClass).removeClass(e.tabActiveClass);
                    $activeTab = f.find('a#' + a).addClass(e.tabActiveClass)
                } else {
                    $activeTab = f.children('li').find('.' + e.tabActiveClass);
                    if (!$activeTab.length) {
                        $activeTab = f.find('a:first').addClass(e.tabActiveClass)
                    }
                    g.saveActive($activeTab)
                }
            },
            setActive: function () {
                $activeTab = f.children('li').find('a.' + e.tabActiveClass).removeClass(e.tabActiveClass);
                $tab.addClass(e.tabActiveClass);
                g.saveActive($tab)
            },
            saveActive: function (a) {
                if (e.tabSaveState == true) {
                    $.cookie(d.attr('id'), a.attr('id'))
                }
            },
            slideClicked: function (a) {
                a.elemP = a.elemP[a.obj];
                a.elemD = $elem[a.func](true);
                a.nextElemPos = ($elem.next().length == 1) ? $elem.next().position()[a.obj] : 0;
                if (a.elemP < (0 + e.offsetTL)) {
                    a.elemHidden = (a.elemD - a.nextElemPos);
                    elemMargin = (elemMargin - (a.elemHidden + e.offsetTL));
                    $next.removeClass(e.btnDisabledClass)
                } else if ((a.elemD + a.elemP) > (e.slideLength - e.offsetBR)) {
                    elemMargin += (a.elemD - (e.slideLength - (a.elemP + e.offsetBR)));
                    $prev.removeClass(e.btnDisabledClass)
                }
                g.animateTabs()
            },
            prevTab: function (a) {
                if ($(g.tabsAnim).length) {
                    return false
                }
                f.children('li').each(function () {
                    $elem = $(this);
                    a.elemP = $elem.position()[a.obj];
                    if (a.elemP >= (0 + e.offsetTL)) {
                        a.elemHidden = ($elem.prev()[a.func](true) - a.elemP);
                        elemMargin = ((elemMargin - a.elemHidden) - e.offsetTL);
                        $elem = $elem.prev();
                        g.animateTabs();
                        return false
                    }
                });
                $next.removeClass(e.btnDisabledClass)
            },
            nextTab: function (a) {
                if ($(g.tabsAnim).length) {
                    return false
                }
                f.children('li').each(function () {
                    $elem = $(this);
                    a.elemD = $elem[a.func](true);
                    a.elemP = $elem.position()[a.obj];
                    if ((a.elemD + a.elemP) > (e.slideLength - e.offsetBR)) {
                        a.elemHidden = (e.slideLength - a.elemP);
                        elemMargin += ((a.elemD - a.elemHidden) + e.offsetBR);
                        g.animateTabs();
                        return false
                    }
                });
                $prev.removeClass(e.btnDisabledClass)
            },
            animateTabs: function () {
                if (e.orientation == 'horizontal') {
                    f.animate({
                        'marginLeft': -+elemMargin
                    }, e.tabsAnimTime, e.tabsEasing)
                } else {
                    f.animate({
                        'marginTop': -+elemMargin
                    }, e.tabsAnimTime, e.tabsEasing)
                }
                g.setButtonState()
            },
            setButtonState: function () {
                if ($elem.is(':first-child')) {
                    $prev.addClass(e.btnDisabledClass)
                } else if ($elem.is(':last-child')) {
                    $next.addClass(e.btnDisabledClass)
                }
            }
        },
            content = {
                contAnim: '#' + d.attr('id') + ' :animated',
                showActiveContent: function () {
                    $view = $content.children($activeTab.attr('href')).addClass(e.viewActiveClass);
                    $content.children('div').css('position', 'absolute').not('div.' + e.viewActiveClass).hide();
                    if (e.autoHeight == true) {
                        $content.css('height', $view.height()).parent().css('height', 'auto')
                    }
                },
                adjustHeight: function () {
                    if (e.autoHeightTime > 0) {
                        $content.animate({
                            'height': $view.height()
                        }, e.autoHeightTime)
                    } else {
                        $content.css('height', $view.height())
                    }
                },
                fade: function () {
                    $activeView.fadeOut(e.contentAnimTime, function () {
                        $view.fadeIn(e.contentAnimTime)
                    })
                },
                slideH: function (a) {
                    a.wh = d.outerWidth(true);
                    content.setSlideValues(a);
                    $activeView.animate({
                        'left': a.animVal
                    }, e.contentAnimTime, e.contentEasing);
                    $view.css({
                        'display': 'block',
                        'left': a.cssVal
                    }).animate({
                        'left': '0px'
                    }, e.contentAnimTime, e.contentEasing, function () {
                        $activeView.css('display', 'none')
                    })
                },
                slideV: function (a) {
                    a.wh = d.outerHeight(true);
                    content.setSlideValues(a);
                    $activeView.animate({
                        'top': a.animVal
                    }, e.contentAnimTime, e.contentEasing);
                    $view.css({
                        'display': 'block',
                        'top': a.cssVal
                    }).animate({
                        'top': '0px'
                    }, e.contentAnimTime, e.contentEasing, function () {
                        $activeView.css('display', 'none')
                    })
                },
                setSlideValues: function (a) {
                    if (a.elemP > a.activeElemP[a.obj]) {
                        a.animVal = -a.wh;
                        a.cssVal = a.wh
                    } else {
                        a.animVal = a.wh;
                        a.cssVal = -a.wh
                    }
                }
            };
    }
})(jQuery);