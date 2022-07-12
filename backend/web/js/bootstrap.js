!(function (e, t) {
    for (var n in t) e[n] = t[n];
})(
    window,
    (function (e) {
        var t = {};
        function n(i) {
            if (t[i]) return t[i].exports;
            var o = (t[i] = { i: i, l: !1, exports: {} });
            return e[i].call(o.exports, o, o.exports, n), (o.l = !0), o.exports;
        }
        return (
            (n.m = e),
                (n.c = t),
                (n.d = function (e, t, i) {
                    n.o(e, t) || Object.defineProperty(e, t, { enumerable: !0, get: i });
                }),
                (n.r = function (e) {
                    "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 });
                }),
                (n.t = function (e, t) {
                    if ((1 & t && (e = n(e)), 8 & t)) return e;
                    if (4 & t && "object" == typeof e && e && e.__esModule) return e;
                    var i = Object.create(null);
                    if ((n.r(i), Object.defineProperty(i, "default", { enumerable: !0, value: e }), 2 & t && "string" != typeof e))
                        for (var o in e)
                            n.d(
                                i,
                                o,
                                function (t) {
                                    return e[t];
                                }.bind(null, o)
                            );
                    return i;
                }),
                (n.n = function (e) {
                    var t =
                        e && e.__esModule
                            ? function () {
                                return e.default;
                            }
                            : function () {
                                return e;
                            };
                    return n.d(t, "a", t), t;
                }),
                (n.o = function (e, t) {
                    return Object.prototype.hasOwnProperty.call(e, t);
                }),
                (n.p = ""),
                n((n.s = 796))
        );
    })({
        0: function (e, t) {
            e.exports = window.jQuery;
        },
        54: function (e, t) {
            e.exports = window.Popper;
        },
        796: function (e, t, n) {
            "use strict";
            n.r(t),
                n.d(t, "Util", function () {
                    return s;
                }),
                n.d(t, "Alert", function () {
                    return _;
                }),
                n.d(t, "Button", function () {
                    return N;
                }),
                n.d(t, "Carousel", function () {
                    return de;
                }),
                n.d(t, "Collapse", function () {
                    return Ne;
                }),
                n.d(t, "Dropdown", function () {
                    return ht;
                }),
                n.d(t, "Modal", function () {
                    return xt;
                }),
                n.d(t, "Scrollspy", function () {
                    return ln;
                }),
                n.d(t, "Tab", function () {
                    return Tn;
                }),
                n.d(t, "Toast", function () {
                    return Kn;
                }),
                n.d(t, "Tooltip", function () {
                    return yi;
                }),
                n.d(t, "Popover", function () {
                    return Wi;
                });
            var i = n(0),
                o = n.n(i);
            function r(e) {
                var t = this,
                    n = !1;
                return (
                    o()(this).one(a.TRANSITION_END, function () {
                        n = !0;
                    }),
                        setTimeout(function () {
                            n || a.triggerTransitionEnd(t);
                        }, e),
                        this
                );
            }
            var a = {
                TRANSITION_END: "bsTransitionEnd",
                getUID: function (e) {
                    do {
                        e += ~~(1e6 * Math.random());
                    } while (document.getElementById(e));
                    return e;
                },
                getSelectorFromElement: function (e) {
                    var t = e.getAttribute("data-target");
                    if (!t || "#" === t) {
                        var n = e.getAttribute("href");
                        t = n && "#" !== n ? n.trim() : "";
                    }
                    try {
                        return document.querySelector(t) ? t : null;
                    } catch (e) {
                        return null;
                    }
                },
                getTransitionDurationFromElement: function (e) {
                    if (!e) return 0;
                    var t = o()(e).css("transition-duration"),
                        n = o()(e).css("transition-delay"),
                        i = parseFloat(t),
                        r = parseFloat(n);
                    return i || r ? ((t = t.split(",")[0]), (n = n.split(",")[0]), 1e3 * (parseFloat(t) + parseFloat(n))) : 0;
                },
                reflow: function (e) {
                    return e.offsetHeight;
                },
                triggerTransitionEnd: function (e) {
                    o()(e).trigger("transitionend");
                },
                supportsTransitionEnd: function () {
                    return Boolean("transitionend");
                },
                isElement: function (e) {
                    return (e[0] || e).nodeType;
                },
                typeCheckConfig: function (e, t, n) {
                    for (var i in n)
                        if (Object.prototype.hasOwnProperty.call(n, i)) {
                            var o = n[i],
                                r = t[i],
                                s =
                                    r && a.isElement(r)
                                        ? "element"
                                        : ((l = r),
                                            {}.toString
                                                .call(l)
                                                .match(/\s([a-z]+)/i)[1]
                                                .toLowerCase());
                            if (!new RegExp(o).test(s)) throw new Error("".concat(e.toUpperCase(), ": ") + 'Option "'.concat(i, '" provided type "').concat(s, '" ') + 'but expected type "'.concat(o, '".'));
                        }
                    var l;
                },
                findShadowRoot: function (e) {
                    if (!document.documentElement.attachShadow) return null;
                    if ("function" == typeof e.getRootNode) {
                        var t = e.getRootNode();
                        return t instanceof ShadowRoot ? t : null;
                    }
                    return e instanceof ShadowRoot ? e : e.parentNode ? a.findShadowRoot(e.parentNode) : null;
                },
                jQueryDetection: function () {
                    if (void 0 === o.a) throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");
                    var e = o.a.fn.jquery.split(" ")[0].split(".");
                    if ((e[0] < 2 && e[1] < 9) || (1 === e[0] && 9 === e[1] && e[2] < 1) || e[0] >= 4) throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0");
                },
            };
            a.jQueryDetection(),
                (o.a.fn.emulateTransitionEnd = r),
                (o.a.event.special[a.TRANSITION_END] = {
                    bindType: "transitionend",
                    delegateType: "transitionend",
                    handle: function (e) {
                        if (o()(e.target).is(this)) return e.handleObj.handler.apply(this, arguments);
                    },
                });
            var s = a;
            function l(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var c = "alert",
                u = ".".concat("bs.alert"),
                f = o.a.fn[c],
                h = { CLOSE: "close".concat(u), CLOSED: "closed".concat(u), CLICK_DATA_API: "click".concat(u).concat(".data-api") },
                d = "alert",
                g = "fade",
                p = "show",
                m = (function () {
                    function e(t) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._element = t);
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this),
                                                i = n.data("bs.alert");
                                            i || ((i = new e(this)), n.data("bs.alert", i)), "close" === t && i[t](this);
                                        });
                                    },
                                },
                                {
                                    key: "_handleDismiss",
                                    value: function (e) {
                                        return function (t) {
                                            t && t.preventDefault(), e.close(this);
                                        };
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "close",
                                value: function (e) {
                                    var t = this._element;
                                    e && (t = this._getRootElement(e)), this._triggerCloseEvent(t).isDefaultPrevented() || this._removeElement(t);
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    o.a.removeData(this._element, "bs.alert"), (this._element = null);
                                },
                            },
                            {
                                key: "_getRootElement",
                                value: function (e) {
                                    var t = s.getSelectorFromElement(e),
                                        n = !1;
                                    return t && (n = document.querySelector(t)), n || (n = o()(e).closest(".".concat(d))[0]), n;
                                },
                            },
                            {
                                key: "_triggerCloseEvent",
                                value: function (e) {
                                    var t = o.a.Event(h.CLOSE);
                                    return o()(e).trigger(t), t;
                                },
                            },
                            {
                                key: "_removeElement",
                                value: function (e) {
                                    var t = this;
                                    if ((o()(e).removeClass(p), o()(e).hasClass(g))) {
                                        var n = s.getTransitionDurationFromElement(e);
                                        o()(e)
                                            .one(s.TRANSITION_END, function (n) {
                                                return t._destroyElement(e, n);
                                            })
                                            .emulateTransitionEnd(n);
                                    } else this._destroyElement(e);
                                },
                            },
                            {
                                key: "_destroyElement",
                                value: function (e) {
                                    o()(e).detach().trigger(h.CLOSED).remove();
                                },
                            },
                        ]) && l(t.prototype, n),
                        i && l(t, i),
                            e
                    );
                })();
            o()(document).on(h.CLICK_DATA_API, '[data-dismiss="alert"]', m._handleDismiss(new m())),
                (o.a.fn[c] = m._jQueryInterface),
                (o.a.fn[c].Constructor = m),
                (o.a.fn[c].noConflict = function () {
                    return (o.a.fn[c] = f), m._jQueryInterface;
                });
            var _ = m;
            function v(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var y = ".".concat("bs.button"),
                b = o.a.fn.button,
                E = "active",
                w = "btn",
                S = "focus",
                C = '[data-toggle^="button"]',
                O = '[data-toggle="buttons"]',
                T = '[data-toggle="button"]',
                D = '[data-toggle="buttons"] .btn',
                k = 'input:not([type="hidden"])',
                I = ".active",
                A = ".btn",
                j = { CLICK_DATA_API: "click".concat(y).concat(".data-api"), FOCUS_BLUR_DATA_API: "focus".concat(y).concat(".data-api", " ") + "blur".concat(y).concat(".data-api"), LOAD_DATA_API: "load".concat(y).concat(".data-api") },
                P = (function () {
                    function e(t) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._element = t);
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this).data("bs.button");
                                            n || ((n = new e(this)), o()(this).data("bs.button", n)), "toggle" === t && n[t]();
                                        });
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "toggle",
                                value: function () {
                                    var e = !0,
                                        t = !0,
                                        n = o()(this._element).closest(O)[0];
                                    if (n) {
                                        var i = this._element.querySelector(k);
                                        if (i) {
                                            if ("radio" === i.type)
                                                if (i.checked && this._element.classList.contains(E)) e = !1;
                                                else {
                                                    var r = n.querySelector(I);
                                                    r && o()(r).removeClass(E);
                                                }
                                            else "checkbox" === i.type ? "LABEL" === this._element.tagName && i.checked === this._element.classList.contains(E) && (e = !1) : (e = !1);
                                            e && ((i.checked = !this._element.classList.contains(E)), o()(i).trigger("change")), i.focus(), (t = !1);
                                        }
                                    }
                                    this._element.hasAttribute("disabled") ||
                                    this._element.classList.contains("disabled") ||
                                    (t && this._element.setAttribute("aria-pressed", !this._element.classList.contains(E)), e && o()(this._element).toggleClass(E));
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    o.a.removeData(this._element, "bs.button"), (this._element = null);
                                },
                            },
                        ]) && v(t.prototype, n),
                        i && v(t, i),
                            e
                    );
                })();
            o()(document)
                .on(j.CLICK_DATA_API, C, function (e) {
                    var t = e.target;
                    if ((o()(t).hasClass(w) || (t = o()(t).closest(A)[0]), !t || t.hasAttribute("disabled") || t.classList.contains("disabled"))) e.preventDefault();
                    else {
                        var n = t.querySelector(k);
                        if (n && (n.hasAttribute("disabled") || n.classList.contains("disabled"))) return void e.preventDefault();
                        P._jQueryInterface.call(o()(t), "toggle");
                    }
                })
                .on(j.FOCUS_BLUR_DATA_API, C, function (e) {
                    var t = o()(e.target).closest(A)[0];
                    o()(t).toggleClass(S, /^focus(in)?$/.test(e.type));
                }),
                o()(window).on(j.LOAD_DATA_API, function () {
                    for (var e = [].slice.call(document.querySelectorAll(D)), t = 0, n = e.length; t < n; t++) {
                        var i = e[t],
                            o = i.querySelector(k);
                        o.checked || o.hasAttribute("checked") ? i.classList.add(E) : i.classList.remove(E);
                    }
                    for (var r = 0, a = (e = [].slice.call(document.querySelectorAll(T))).length; r < a; r++) {
                        var s = e[r];
                        "true" === s.getAttribute("aria-pressed") ? s.classList.add(E) : s.classList.remove(E);
                    }
                }),
                (o.a.fn.button = P._jQueryInterface),
                (o.a.fn.button.Constructor = P),
                (o.a.fn.button.noConflict = function () {
                    return (o.a.fn.button = b), P._jQueryInterface;
                });
            var N = P;
            function L(e) {
                return (L =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                            return typeof e;
                        }
                        : function (e) {
                            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                        })(e);
            }
            function R(e, t) {
                var n = Object.keys(e);
                if (Object.getOwnPropertySymbols) {
                    var i = Object.getOwnPropertySymbols(e);
                    t &&
                    (i = i.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                        n.push.apply(n, i);
                }
                return n;
            }
            function H(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = null != arguments[t] ? arguments[t] : {};
                    t % 2
                        ? R(Object(n), !0).forEach(function (t) {
                            x(e, t, n[t]);
                        })
                        : Object.getOwnPropertyDescriptors
                            ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                            : R(Object(n)).forEach(function (t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                            });
                }
                return e;
            }
            function x(e, t, n) {
                return t in e ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = n), e;
            }
            function F(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var U = ".".concat("bs.carousel"),
                M = o.a.fn.carousel,
                W = { interval: 5e3, keyboard: !0, slide: !1, pause: "hover", wrap: !0, touch: !0 },
                q = { interval: "(number|boolean)", keyboard: "boolean", slide: "(boolean|string)", pause: "(string|boolean)", wrap: "boolean", touch: "boolean" },
                K = "next",
                Q = "prev",
                B = "left",
                V = "right",
                Y = {
                    SLIDE: "slide".concat(U),
                    SLID: "slid".concat(U),
                    KEYDOWN: "keydown".concat(U),
                    MOUSEENTER: "mouseenter".concat(U),
                    MOUSELEAVE: "mouseleave".concat(U),
                    TOUCHSTART: "touchstart".concat(U),
                    TOUCHMOVE: "touchmove".concat(U),
                    TOUCHEND: "touchend".concat(U),
                    POINTERDOWN: "pointerdown".concat(U),
                    POINTERUP: "pointerup".concat(U),
                    DRAG_START: "dragstart".concat(U),
                    LOAD_DATA_API: "load".concat(U).concat(".data-api"),
                    CLICK_DATA_API: "click".concat(U).concat(".data-api"),
                },
                z = "carousel",
                X = "active",
                G = "slide",
                J = "carousel-item-right",
                Z = "carousel-item-left",
                ee = "carousel-item-next",
                te = "carousel-item-prev",
                ne = "pointer-event",
                ie = ".active",
                oe = ".active.carousel-item",
                re = ".carousel-item",
                ae = ".carousel-item img",
                se = ".carousel-item-next, .carousel-item-prev",
                le = ".carousel-indicators",
                ce = "[data-slide], [data-slide-to]",
                ue = '[data-ride="carousel"]',
                fe = { TOUCH: "touch", PEN: "pen" },
                he = (function () {
                    function e(t, n) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._items = null),
                            (this._interval = null),
                            (this._activeElement = null),
                            (this._isPaused = !1),
                            (this._isSliding = !1),
                            (this.touchTimeout = null),
                            (this.touchStartX = 0),
                            (this.touchDeltaX = 0),
                            (this._config = this._getConfig(n)),
                            (this._element = t),
                            (this._indicatorsElement = this._element.querySelector(le)),
                            (this._touchSupported = "ontouchstart" in document.documentElement || navigator.maxTouchPoints > 0),
                            (this._pointerEvent = Boolean(window.PointerEvent || window.MSPointerEvent)),
                            this._addEventListeners();
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this).data("bs.carousel"),
                                                i = H(H({}, W), o()(this).data());
                                            "object" === L(t) && (i = H(H({}, i), t));
                                            var r = "string" == typeof t ? t : i.slide;
                                            if ((n || ((n = new e(this, i)), o()(this).data("bs.carousel", n)), "number" == typeof t)) n.to(t);
                                            else if ("string" == typeof r) {
                                                if (void 0 === n[r]) throw new TypeError('No method named "'.concat(r, '"'));
                                                n[r]();
                                            } else i.interval && i.ride && (n.pause(), n.cycle());
                                        });
                                    },
                                },
                                {
                                    key: "_dataApiClickHandler",
                                    value: function (t) {
                                        var n = s.getSelectorFromElement(this);
                                        if (n) {
                                            var i = o()(n)[0];
                                            if (i && o()(i).hasClass(z)) {
                                                var r = H(H({}, o()(i).data()), o()(this).data()),
                                                    a = this.getAttribute("data-slide-to");
                                                a && (r.interval = !1), e._jQueryInterface.call(o()(i), r), a && o()(i).data("bs.carousel").to(a), t.preventDefault();
                                            }
                                        }
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return W;
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "next",
                                value: function () {
                                    this._isSliding || this._slide(K);
                                },
                            },
                            {
                                key: "nextWhenVisible",
                                value: function () {
                                    !document.hidden && o()(this._element).is(":visible") && "hidden" !== o()(this._element).css("visibility") && this.next();
                                },
                            },
                            {
                                key: "prev",
                                value: function () {
                                    this._isSliding || this._slide(Q);
                                },
                            },
                            {
                                key: "pause",
                                value: function (e) {
                                    e || (this._isPaused = !0), this._element.querySelector(se) && (s.triggerTransitionEnd(this._element), this.cycle(!0)), clearInterval(this._interval), (this._interval = null);
                                },
                            },
                            {
                                key: "cycle",
                                value: function (e) {
                                    e || (this._isPaused = !1),
                                    this._interval && (clearInterval(this._interval), (this._interval = null)),
                                    this._config.interval && !this._isPaused && (this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval));
                                },
                            },
                            {
                                key: "to",
                                value: function (e) {
                                    var t = this;
                                    this._activeElement = this._element.querySelector(oe);
                                    var n = this._getItemIndex(this._activeElement);
                                    if (!(e > this._items.length - 1 || e < 0))
                                        if (this._isSliding)
                                            o()(this._element).one(Y.SLID, function () {
                                                return t.to(e);
                                            });
                                        else {
                                            if (n === e) return this.pause(), void this.cycle();
                                            var i = e > n ? K : Q;
                                            this._slide(i, this._items[e]);
                                        }
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    o()(this._element).off(U),
                                        o.a.removeData(this._element, "bs.carousel"),
                                        (this._items = null),
                                        (this._config = null),
                                        (this._element = null),
                                        (this._interval = null),
                                        (this._isPaused = null),
                                        (this._isSliding = null),
                                        (this._activeElement = null),
                                        (this._indicatorsElement = null);
                                },
                            },
                            {
                                key: "_getConfig",
                                value: function (e) {
                                    return (e = H(H({}, W), e)), s.typeCheckConfig("carousel", e, q), e;
                                },
                            },
                            {
                                key: "_handleSwipe",
                                value: function () {
                                    var e = Math.abs(this.touchDeltaX);
                                    if (!(e <= 40)) {
                                        var t = e / this.touchDeltaX;
                                        (this.touchDeltaX = 0), t > 0 && this.prev(), t < 0 && this.next();
                                    }
                                },
                            },
                            {
                                key: "_addEventListeners",
                                value: function () {
                                    var e = this;
                                    this._config.keyboard &&
                                    o()(this._element).on(Y.KEYDOWN, function (t) {
                                        return e._keydown(t);
                                    }),
                                    "hover" === this._config.pause &&
                                    o()(this._element)
                                        .on(Y.MOUSEENTER, function (t) {
                                            return e.pause(t);
                                        })
                                        .on(Y.MOUSELEAVE, function (t) {
                                            return e.cycle(t);
                                        }),
                                    this._config.touch && this._addTouchEventListeners();
                                },
                            },
                            {
                                key: "_addTouchEventListeners",
                                value: function () {
                                    var e = this;
                                    if (this._touchSupported) {
                                        var t = function (t) {
                                                e._pointerEvent && fe[t.originalEvent.pointerType.toUpperCase()] ? (e.touchStartX = t.originalEvent.clientX) : e._pointerEvent || (e.touchStartX = t.originalEvent.touches[0].clientX);
                                            },
                                            n = function (t) {
                                                e._pointerEvent && fe[t.originalEvent.pointerType.toUpperCase()] && (e.touchDeltaX = t.originalEvent.clientX - e.touchStartX),
                                                    e._handleSwipe(),
                                                "hover" === e._config.pause &&
                                                (e.pause(),
                                                e.touchTimeout && clearTimeout(e.touchTimeout),
                                                    (e.touchTimeout = setTimeout(function (t) {
                                                        return e.cycle(t);
                                                    }, 500 + e._config.interval)));
                                            };
                                        o()(this._element.querySelectorAll(ae)).on(Y.DRAG_START, function (e) {
                                            return e.preventDefault();
                                        }),
                                            this._pointerEvent
                                                ? (o()(this._element).on(Y.POINTERDOWN, function (e) {
                                                    return t(e);
                                                }),
                                                    o()(this._element).on(Y.POINTERUP, function (e) {
                                                        return n(e);
                                                    }),
                                                    this._element.classList.add(ne))
                                                : (o()(this._element).on(Y.TOUCHSTART, function (e) {
                                                    return t(e);
                                                }),
                                                    o()(this._element).on(Y.TOUCHMOVE, function (t) {
                                                        return (function (t) {
                                                            t.originalEvent.touches && t.originalEvent.touches.length > 1 ? (e.touchDeltaX = 0) : (e.touchDeltaX = t.originalEvent.touches[0].clientX - e.touchStartX);
                                                        })(t);
                                                    }),
                                                    o()(this._element).on(Y.TOUCHEND, function (e) {
                                                        return n(e);
                                                    }));
                                    }
                                },
                            },
                            {
                                key: "_keydown",
                                value: function (e) {
                                    if (!/input|textarea/i.test(e.target.tagName))
                                        switch (e.which) {
                                            case 37:
                                                e.preventDefault(), this.prev();
                                                break;
                                            case 39:
                                                e.preventDefault(), this.next();
                                        }
                                },
                            },
                            {
                                key: "_getItemIndex",
                                value: function (e) {
                                    return (this._items = e && e.parentNode ? [].slice.call(e.parentNode.querySelectorAll(re)) : []), this._items.indexOf(e);
                                },
                            },
                            {
                                key: "_getItemByDirection",
                                value: function (e, t) {
                                    var n = e === K,
                                        i = e === Q,
                                        o = this._getItemIndex(t),
                                        r = this._items.length - 1;
                                    if (((i && 0 === o) || (n && o === r)) && !this._config.wrap) return t;
                                    var a = (o + (e === Q ? -1 : 1)) % this._items.length;
                                    return -1 === a ? this._items[this._items.length - 1] : this._items[a];
                                },
                            },
                            {
                                key: "_triggerSlideEvent",
                                value: function (e, t) {
                                    var n = this._getItemIndex(e),
                                        i = this._getItemIndex(this._element.querySelector(oe)),
                                        r = o.a.Event(Y.SLIDE, { relatedTarget: e, direction: t, from: i, to: n });
                                    return o()(this._element).trigger(r), r;
                                },
                            },
                            {
                                key: "_setActiveIndicatorElement",
                                value: function (e) {
                                    if (this._indicatorsElement) {
                                        var t = [].slice.call(this._indicatorsElement.querySelectorAll(ie));
                                        o()(t).removeClass(X);
                                        var n = this._indicatorsElement.children[this._getItemIndex(e)];
                                        n && o()(n).addClass(X);
                                    }
                                },
                            },
                            {
                                key: "_slide",
                                value: function (e, t) {
                                    var n,
                                        i,
                                        r,
                                        a = this,
                                        l = this._element.querySelector(oe),
                                        c = this._getItemIndex(l),
                                        u = t || (l && this._getItemByDirection(e, l)),
                                        f = this._getItemIndex(u),
                                        h = Boolean(this._interval);
                                    if ((e === K ? ((n = Z), (i = ee), (r = B)) : ((n = J), (i = te), (r = V)), u && o()(u).hasClass(X))) this._isSliding = !1;
                                    else if (!this._triggerSlideEvent(u, r).isDefaultPrevented() && l && u) {
                                        (this._isSliding = !0), h && this.pause(), this._setActiveIndicatorElement(u);
                                        var d = o.a.Event(Y.SLID, { relatedTarget: u, direction: r, from: c, to: f });
                                        if (o()(this._element).hasClass(G)) {
                                            o()(u).addClass(i), s.reflow(u), o()(l).addClass(n), o()(u).addClass(n);
                                            var g = parseInt(u.getAttribute("data-interval"), 10);
                                            g
                                                ? ((this._config.defaultInterval = this._config.defaultInterval || this._config.interval), (this._config.interval = g))
                                                : (this._config.interval = this._config.defaultInterval || this._config.interval);
                                            var p = s.getTransitionDurationFromElement(l);
                                            o()(l)
                                                .one(s.TRANSITION_END, function () {
                                                    o()(u).removeClass("".concat(n, " ").concat(i)).addClass(X),
                                                        o()(l).removeClass("".concat(X, " ").concat(i, " ").concat(n)),
                                                        (a._isSliding = !1),
                                                        setTimeout(function () {
                                                            return o()(a._element).trigger(d);
                                                        }, 0);
                                                })
                                                .emulateTransitionEnd(p);
                                        } else o()(l).removeClass(X), o()(u).addClass(X), (this._isSliding = !1), o()(this._element).trigger(d);
                                        h && this.cycle();
                                    }
                                },
                            },
                        ]) && F(t.prototype, n),
                        i && F(t, i),
                            e
                    );
                })();
            o()(document).on(Y.CLICK_DATA_API, ce, he._dataApiClickHandler),
                o()(window).on(Y.LOAD_DATA_API, function () {
                    for (var e = [].slice.call(document.querySelectorAll(ue)), t = 0, n = e.length; t < n; t++) {
                        var i = o()(e[t]);
                        he._jQueryInterface.call(i, i.data());
                    }
                }),
                (o.a.fn.carousel = he._jQueryInterface),
                (o.a.fn.carousel.Constructor = he),
                (o.a.fn.carousel.noConflict = function () {
                    return (o.a.fn.carousel = M), he._jQueryInterface;
                });
            var de = he;
            function ge(e) {
                return (ge =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                            return typeof e;
                        }
                        : function (e) {
                            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                        })(e);
            }
            function pe(e, t) {
                var n = Object.keys(e);
                if (Object.getOwnPropertySymbols) {
                    var i = Object.getOwnPropertySymbols(e);
                    t &&
                    (i = i.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                        n.push.apply(n, i);
                }
                return n;
            }
            function me(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = null != arguments[t] ? arguments[t] : {};
                    t % 2
                        ? pe(Object(n), !0).forEach(function (t) {
                            _e(e, t, n[t]);
                        })
                        : Object.getOwnPropertyDescriptors
                            ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                            : pe(Object(n)).forEach(function (t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                            });
                }
                return e;
            }
            function _e(e, t, n) {
                return t in e ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = n), e;
            }
            function ve(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var ye = ".".concat("bs.collapse"),
                be = o.a.fn.collapse,
                Ee = { toggle: !0, parent: "" },
                we = { toggle: "boolean", parent: "(string|element)" },
                Se = { SHOW: "show".concat(ye), SHOWN: "shown".concat(ye), HIDE: "hide".concat(ye), HIDDEN: "hidden".concat(ye), CLICK_DATA_API: "click".concat(ye).concat(".data-api") },
                Ce = "show",
                Oe = "collapse",
                Te = "collapsing",
                De = "collapsed",
                ke = "width",
                Ie = "height",
                Ae = ".show, .collapsing",
                je = '[data-toggle="collapse"]',
                Pe = (function () {
                    function e(t, n) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._isTransitioning = !1),
                            (this._element = t),
                            (this._config = this._getConfig(n)),
                            (this._triggerArray = [].slice.call(document.querySelectorAll('[data-toggle="collapse"][href="#'.concat(t.id, '"],') + '[data-toggle="collapse"][data-target="#'.concat(t.id, '"]'))));
                        for (var i = [].slice.call(document.querySelectorAll(je)), o = 0, r = i.length; o < r; o++) {
                            var a = i[o],
                                l = s.getSelectorFromElement(a),
                                c = [].slice.call(document.querySelectorAll(l)).filter(function (e) {
                                    return e === t;
                                });
                            null !== l && c.length > 0 && ((this._selector = l), this._triggerArray.push(a));
                        }
                        (this._parent = this._config.parent ? this._getParent() : null), this._config.parent || this._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle();
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_getTargetFromElement",
                                    value: function (e) {
                                        var t = s.getSelectorFromElement(e);
                                        return t ? document.querySelector(t) : null;
                                    },
                                },
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this),
                                                i = n.data("bs.collapse"),
                                                r = me(me(me({}, Ee), n.data()), "object" === ge(t) && t ? t : {});
                                            if ((!i && r.toggle && /show|hide/.test(t) && (r.toggle = !1), i || ((i = new e(this, r)), n.data("bs.collapse", i)), "string" == typeof t)) {
                                                if (void 0 === i[t]) throw new TypeError('No method named "'.concat(t, '"'));
                                                i[t]();
                                            }
                                        });
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return Ee;
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "toggle",
                                value: function () {
                                    o()(this._element).hasClass(Ce) ? this.hide() : this.show();
                                },
                            },
                            {
                                key: "show",
                                value: function () {
                                    var t,
                                        n,
                                        i = this;
                                    if (
                                        !(
                                            this._isTransitioning ||
                                            o()(this._element).hasClass(Ce) ||
                                            (this._parent &&
                                            0 ===
                                            (t = [].slice.call(this._parent.querySelectorAll(Ae)).filter(function (e) {
                                                return "string" == typeof i._config.parent ? e.getAttribute("data-parent") === i._config.parent : e.classList.contains(Oe);
                                            })).length &&
                                            (t = null),
                                            t && (n = o()(t).not(this._selector).data("bs.collapse")) && n._isTransitioning)
                                        )
                                    ) {
                                        var r = o.a.Event(Se.SHOW);
                                        if ((o()(this._element).trigger(r), !r.isDefaultPrevented())) {
                                            t && (e._jQueryInterface.call(o()(t).not(this._selector), "hide"), n || o()(t).data("bs.collapse", null));
                                            var a = this._getDimension();
                                            o()(this._element).removeClass(Oe).addClass(Te),
                                                (this._element.style[a] = 0),
                                            this._triggerArray.length && o()(this._triggerArray).removeClass(De).attr("aria-expanded", !0),
                                                this.setTransitioning(!0);
                                            var l = a[0].toUpperCase() + a.slice(1),
                                                c = "scroll".concat(l),
                                                u = s.getTransitionDurationFromElement(this._element);
                                            o()(this._element)
                                                .one(s.TRANSITION_END, function () {
                                                    o()(i._element).removeClass(Te).addClass(Oe).addClass(Ce), (i._element.style[a] = ""), i.setTransitioning(!1), o()(i._element).trigger(Se.SHOWN);
                                                })
                                                .emulateTransitionEnd(u),
                                                (this._element.style[a] = "".concat(this._element[c], "px"));
                                        }
                                    }
                                },
                            },
                            {
                                key: "hide",
                                value: function () {
                                    var e = this;
                                    if (!this._isTransitioning && o()(this._element).hasClass(Ce)) {
                                        var t = o.a.Event(Se.HIDE);
                                        if ((o()(this._element).trigger(t), !t.isDefaultPrevented())) {
                                            var n = this._getDimension();
                                            (this._element.style[n] = "".concat(this._element.getBoundingClientRect()[n], "px")), s.reflow(this._element), o()(this._element).addClass(Te).removeClass(Oe).removeClass(Ce);
                                            var i = this._triggerArray.length;
                                            if (i > 0)
                                                for (var r = 0; r < i; r++) {
                                                    var a = this._triggerArray[r],
                                                        l = s.getSelectorFromElement(a);
                                                    null !== l && (o()([].slice.call(document.querySelectorAll(l))).hasClass(Ce) || o()(a).addClass(De).attr("aria-expanded", !1));
                                                }
                                            this.setTransitioning(!0), (this._element.style[n] = "");
                                            var c = s.getTransitionDurationFromElement(this._element);
                                            o()(this._element)
                                                .one(s.TRANSITION_END, function () {
                                                    e.setTransitioning(!1), o()(e._element).removeClass(Te).addClass(Oe).trigger(Se.HIDDEN);
                                                })
                                                .emulateTransitionEnd(c);
                                        }
                                    }
                                },
                            },
                            {
                                key: "setTransitioning",
                                value: function (e) {
                                    this._isTransitioning = e;
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    o.a.removeData(this._element, "bs.collapse"), (this._config = null), (this._parent = null), (this._element = null), (this._triggerArray = null), (this._isTransitioning = null);
                                },
                            },
                            {
                                key: "_getConfig",
                                value: function (e) {
                                    return ((e = me(me({}, Ee), e)).toggle = Boolean(e.toggle)), s.typeCheckConfig("collapse", e, we), e;
                                },
                            },
                            {
                                key: "_getDimension",
                                value: function () {
                                    return o()(this._element).hasClass(ke) ? ke : Ie;
                                },
                            },
                            {
                                key: "_getParent",
                                value: function () {
                                    var t,
                                        n = this;
                                    s.isElement(this._config.parent) ? ((t = this._config.parent), void 0 !== this._config.parent.jquery && (t = this._config.parent[0])) : (t = document.querySelector(this._config.parent));
                                    var i = '[data-toggle="collapse"][data-parent="'.concat(this._config.parent, '"]'),
                                        r = [].slice.call(t.querySelectorAll(i));
                                    return (
                                        o()(r).each(function (t, i) {
                                            n._addAriaAndCollapsedClass(e._getTargetFromElement(i), [i]);
                                        }),
                                            t
                                    );
                                },
                            },
                            {
                                key: "_addAriaAndCollapsedClass",
                                value: function (e, t) {
                                    var n = o()(e).hasClass(Ce);
                                    t.length && o()(t).toggleClass(De, !n).attr("aria-expanded", n);
                                },
                            },
                        ]) && ve(t.prototype, n),
                        i && ve(t, i),
                            e
                    );
                })();
            o()(document).on(Se.CLICK_DATA_API, je, function (e) {
                "A" === e.currentTarget.tagName && e.preventDefault();
                var t = o()(this),
                    n = s.getSelectorFromElement(this),
                    i = [].slice.call(document.querySelectorAll(n));
                o()(i).each(function () {
                    var e = o()(this),
                        n = e.data("bs.collapse") ? "toggle" : t.data();
                    Pe._jQueryInterface.call(e, n);
                });
            }),
                (o.a.fn.collapse = Pe._jQueryInterface),
                (o.a.fn.collapse.Constructor = Pe),
                (o.a.fn.collapse.noConflict = function () {
                    return (o.a.fn.collapse = be), Pe._jQueryInterface;
                });
            var Ne = Pe,
                Le = n(54),
                Re = n.n(Le);
            function He(e) {
                return (He =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                            return typeof e;
                        }
                        : function (e) {
                            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                        })(e);
            }
            function xe(e, t) {
                var n = Object.keys(e);
                if (Object.getOwnPropertySymbols) {
                    var i = Object.getOwnPropertySymbols(e);
                    t &&
                    (i = i.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                        n.push.apply(n, i);
                }
                return n;
            }
            function Fe(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = null != arguments[t] ? arguments[t] : {};
                    t % 2
                        ? xe(Object(n), !0).forEach(function (t) {
                            Ue(e, t, n[t]);
                        })
                        : Object.getOwnPropertyDescriptors
                            ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                            : xe(Object(n)).forEach(function (t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                            });
                }
                return e;
            }
            function Ue(e, t, n) {
                return t in e ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = n), e;
            }
            function Me(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var We = ".".concat("bs.dropdown"),
                qe = o.a.fn.dropdown,
                Ke = new RegExp("".concat(38, "|").concat(40, "|").concat(27)),
                Qe = {
                    HIDE: "hide".concat(We),
                    HIDDEN: "hidden".concat(We),
                    SHOW: "show".concat(We),
                    SHOWN: "shown".concat(We),
                    CLICK: "click".concat(We),
                    CLICK_DATA_API: "click".concat(We).concat(".data-api"),
                    KEYDOWN_DATA_API: "keydown".concat(We).concat(".data-api"),
                    KEYUP_DATA_API: "keyup".concat(We).concat(".data-api"),
                },
                Be = "disabled",
                Ve = "show",
                Ye = "dropup",
                ze = "dropright",
                Xe = "dropleft",
                $e = "dropdown-menu-right",
                Ge = "position-static",
                Je = '[data-toggle="dropdown"]',
                Ze = ".dropdown form",
                et = ".dropdown-menu",
                tt = ".navbar-nav",
                nt = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)",
                it = "top-start",
                ot = "top-end",
                rt = "bottom-start",
                at = "bottom-end",
                st = "right-start",
                lt = "left-start",
                ct = { offset: 0, flip: !0, boundary: "scrollParent", reference: "toggle", display: "dynamic", popperConfig: null },
                ut = { offset: "(number|string|function)", flip: "boolean", boundary: "(string|element)", reference: "(string|element)", display: "string", popperConfig: "(null|object)" },
                ft = (function () {
                    function e(t, n) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._element = t),
                            (this._popper = null),
                            (this._config = this._getConfig(n)),
                            (this._menu = this._getMenuElement()),
                            (this._inNavbar = this._detectNavbar()),
                            this._addEventListeners();
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this).data("bs.dropdown"),
                                                i = "object" === He(t) ? t : null;
                                            if ((n || ((n = new e(this, i)), o()(this).data("bs.dropdown", n)), "string" == typeof t)) {
                                                if (void 0 === n[t]) throw new TypeError('No method named "'.concat(t, '"'));
                                                n[t]();
                                            }
                                        });
                                    },
                                },
                                {
                                    key: "_clearMenus",
                                    value: function (t) {
                                        if (!t || (3 !== t.which && ("keyup" !== t.type || 9 === t.which)))
                                            for (var n = [].slice.call(document.querySelectorAll(Je)), i = 0, r = n.length; i < r; i++) {
                                                var a = e._getParentFromElement(n[i]),
                                                    s = o()(n[i]).data("bs.dropdown"),
                                                    l = { relatedTarget: n[i] };
                                                if ((t && "click" === t.type && (l.clickEvent = t), s)) {
                                                    var c = s._menu;
                                                    if (o()(a).hasClass(Ve) && !(t && (("click" === t.type && /input|textarea/i.test(t.target.tagName)) || ("keyup" === t.type && 9 === t.which)) && o.a.contains(a, t.target))) {
                                                        var u = o.a.Event(Qe.HIDE, l);
                                                        o()(a).trigger(u),
                                                        u.isDefaultPrevented() ||
                                                        ("ontouchstart" in document.documentElement && o()(document.body).children().off("mouseover", null, o.a.noop),
                                                            n[i].setAttribute("aria-expanded", "false"),
                                                        s._popper && s._popper.destroy(),
                                                            o()(c).removeClass(Ve),
                                                            o()(a).removeClass(Ve).trigger(o.a.Event(Qe.HIDDEN, l)));
                                                    }
                                                }
                                            }
                                    },
                                },
                                {
                                    key: "_getParentFromElement",
                                    value: function (e) {
                                        var t,
                                            n = s.getSelectorFromElement(e);
                                        return n && (t = document.querySelector(n)), t || e.parentNode;
                                    },
                                },
                                {
                                    key: "_dataApiKeydownHandler",
                                    value: function (t) {
                                        if (
                                            !(/input|textarea/i.test(t.target.tagName) ? 32 === t.which || (27 !== t.which && ((40 !== t.which && 38 !== t.which) || o()(t.target).closest(et).length)) : !Ke.test(t.which)) &&
                                            (t.preventDefault(), t.stopPropagation(), !this.disabled && !o()(this).hasClass(Be))
                                        ) {
                                            var n = e._getParentFromElement(this),
                                                i = o()(n).hasClass(Ve);
                                            if (i || 27 !== t.which)
                                                if (i && (!i || (27 !== t.which && 32 !== t.which))) {
                                                    var r = [].slice.call(n.querySelectorAll(nt)).filter(function (e) {
                                                        return o()(e).is(":visible");
                                                    });
                                                    if (0 !== r.length) {
                                                        var a = r.indexOf(t.target);
                                                        38 === t.which && a > 0 && a--, 40 === t.which && a < r.length - 1 && a++, a < 0 && (a = 0), r[a].focus();
                                                    }
                                                } else {
                                                    if (27 === t.which) {
                                                        var s = n.querySelector(Je);
                                                        o()(s).trigger("focus");
                                                    }
                                                    o()(this).trigger("click");
                                                }
                                        }
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return ct;
                                    },
                                },
                                {
                                    key: "DefaultType",
                                    get: function () {
                                        return ut;
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "toggle",
                                value: function () {
                                    if (!this._element.disabled && !o()(this._element).hasClass(Be)) {
                                        var t = o()(this._menu).hasClass(Ve);
                                        e._clearMenus(), t || this.show(!0);
                                    }
                                },
                            },
                            {
                                key: "show",
                                value: function () {
                                    var t = arguments.length > 0 && void 0 !== arguments[0] && arguments[0];
                                    if (!(this._element.disabled || o()(this._element).hasClass(Be) || o()(this._menu).hasClass(Ve))) {
                                        var n = { relatedTarget: this._element },
                                            i = o.a.Event(Qe.SHOW, n),
                                            r = e._getParentFromElement(this._element);
                                        if ((o()(r).trigger(i), !i.isDefaultPrevented())) {
                                            if (!this._inNavbar && t) {
                                                if (void 0 === Re.a) throw new TypeError("Bootstrap's dropdowns require Popper.js (https://popper.js.org/)");
                                                var a = this._element;
                                                "parent" === this._config.reference
                                                    ? (a = r)
                                                    : s.isElement(this._config.reference) && ((a = this._config.reference), void 0 !== this._config.reference.jquery && (a = this._config.reference[0])),
                                                "scrollParent" !== this._config.boundary && o()(r).addClass(Ge),
                                                    (this._popper = new Re.a(a, this._menu, this._getPopperConfig()));
                                            }
                                            "ontouchstart" in document.documentElement && 0 === o()(r).closest(tt).length && o()(document.body).children().on("mouseover", null, o.a.noop),
                                                this._element.focus(),
                                                this._element.setAttribute("aria-expanded", !0),
                                                o()(this._menu).toggleClass(Ve),
                                                o()(r).toggleClass(Ve).trigger(o.a.Event(Qe.SHOWN, n));
                                        }
                                    }
                                },
                            },
                            {
                                key: "hide",
                                value: function () {
                                    if (!this._element.disabled && !o()(this._element).hasClass(Be) && o()(this._menu).hasClass(Ve)) {
                                        var t = { relatedTarget: this._element },
                                            n = o.a.Event(Qe.HIDE, t),
                                            i = e._getParentFromElement(this._element);
                                        o()(i).trigger(n), n.isDefaultPrevented() || (this._popper && this._popper.destroy(), o()(this._menu).toggleClass(Ve), o()(i).toggleClass(Ve).trigger(o.a.Event(Qe.HIDDEN, t)));
                                    }
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    o.a.removeData(this._element, "bs.dropdown"), o()(this._element).off(We), (this._element = null), (this._menu = null), null !== this._popper && (this._popper.destroy(), (this._popper = null));
                                },
                            },
                            {
                                key: "update",
                                value: function () {
                                    (this._inNavbar = this._detectNavbar()), null !== this._popper && this._popper.scheduleUpdate();
                                },
                            },
                            {
                                key: "_addEventListeners",
                                value: function () {
                                    var e = this;
                                    o()(this._element).on(Qe.CLICK, function (t) {
                                        t.preventDefault(), t.stopPropagation(), e.toggle();
                                    });
                                },
                            },
                            {
                                key: "_getConfig",
                                value: function (e) {
                                    return (e = Fe(Fe(Fe({}, this.constructor.Default), o()(this._element).data()), e)), s.typeCheckConfig("dropdown", e, this.constructor.DefaultType), e;
                                },
                            },
                            {
                                key: "_getMenuElement",
                                value: function () {
                                    if (!this._menu) {
                                        var t = e._getParentFromElement(this._element);
                                        t && (this._menu = t.querySelector(et));
                                    }
                                    return this._menu;
                                },
                            },
                            {
                                key: "_getPlacement",
                                value: function () {
                                    var e = o()(this._element.parentNode),
                                        t = rt;
                                    return e.hasClass(Ye) ? ((t = it), o()(this._menu).hasClass($e) && (t = ot)) : e.hasClass(ze) ? (t = st) : e.hasClass(Xe) ? (t = lt) : o()(this._menu).hasClass($e) && (t = at), t;
                                },
                            },
                            {
                                key: "_detectNavbar",
                                value: function () {
                                    return o()(this._element).closest(".navbar").length > 0;
                                },
                            },
                            {
                                key: "_getOffset",
                                value: function () {
                                    var e = this,
                                        t = {};
                                    return (
                                        "function" == typeof this._config.offset
                                            ? (t.fn = function (t) {
                                                return (t.offsets = Fe(Fe({}, t.offsets), e._config.offset(t.offsets, e._element) || {})), t;
                                            })
                                            : (t.offset = this._config.offset),
                                            t
                                    );
                                },
                            },
                            {
                                key: "_getPopperConfig",
                                value: function () {
                                    var e = { placement: this._getPlacement(), modifiers: { offset: this._getOffset(), flip: { enabled: this._config.flip }, preventOverflow: { boundariesElement: this._config.boundary } } };
                                    return "static" === this._config.display && (e.modifiers.applyStyle = { enabled: !1 }), Fe(Fe({}, e), this._config.popperConfig);
                                },
                            },
                        ]) && Me(t.prototype, n),
                        i && Me(t, i),
                            e
                    );
                })();
            o()(document)
                .on(Qe.KEYDOWN_DATA_API, Je, ft._dataApiKeydownHandler)
                .on(Qe.KEYDOWN_DATA_API, et, ft._dataApiKeydownHandler)
                .on("".concat(Qe.CLICK_DATA_API, " ").concat(Qe.KEYUP_DATA_API), ft._clearMenus)
                .on(Qe.CLICK_DATA_API, Je, function (e) {
                    e.preventDefault(), e.stopPropagation(), ft._jQueryInterface.call(o()(this), "toggle");
                })
                .on(Qe.CLICK_DATA_API, Ze, function (e) {
                    e.stopPropagation();
                }),
                (o.a.fn.dropdown = ft._jQueryInterface),
                (o.a.fn.dropdown.Constructor = ft),
                (o.a.fn.dropdown.noConflict = function () {
                    return (o.a.fn.dropdown = qe), ft._jQueryInterface;
                });
            var ht = ft;
            function dt(e) {
                return (dt =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                            return typeof e;
                        }
                        : function (e) {
                            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                        })(e);
            }
            function gt(e, t) {
                var n = Object.keys(e);
                if (Object.getOwnPropertySymbols) {
                    var i = Object.getOwnPropertySymbols(e);
                    t &&
                    (i = i.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                        n.push.apply(n, i);
                }
                return n;
            }
            function pt(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = null != arguments[t] ? arguments[t] : {};
                    t % 2
                        ? gt(Object(n), !0).forEach(function (t) {
                            mt(e, t, n[t]);
                        })
                        : Object.getOwnPropertyDescriptors
                            ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                            : gt(Object(n)).forEach(function (t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                            });
                }
                return e;
            }
            function mt(e, t, n) {
                return t in e ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = n), e;
            }
            function _t(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var vt = ".".concat("bs.modal"),
                yt = o.a.fn.modal,
                bt = { backdrop: !0, keyboard: !0, focus: !0, show: !0 },
                Et = { backdrop: "(boolean|string)", keyboard: "boolean", focus: "boolean", show: "boolean" },
                wt = {
                    HIDE: "hide".concat(vt),
                    HIDE_PREVENTED: "hidePrevented".concat(vt),
                    HIDDEN: "hidden".concat(vt),
                    SHOW: "show".concat(vt),
                    SHOWN: "shown".concat(vt),
                    FOCUSIN: "focusin".concat(vt),
                    RESIZE: "resize".concat(vt),
                    CLICK_DISMISS: "click.dismiss".concat(vt),
                    KEYDOWN_DISMISS: "keydown.dismiss".concat(vt),
                    MOUSEUP_DISMISS: "mouseup.dismiss".concat(vt),
                    MOUSEDOWN_DISMISS: "mousedown.dismiss".concat(vt),
                    CLICK_DATA_API: "click".concat(vt).concat(".data-api"),
                },
                St = "modal-dialog-scrollable",
                Ct = "modal-scrollbar-measure",
                Ot = "modal-backdrop",
                Tt = "modal-open",
                Dt = "fade",
                kt = "show",
                It = "modal-static",
                At = ".modal-dialog",
                jt = ".modal-body",
                Pt = '[data-toggle="modal"]',
                Nt = '[data-dismiss="modal"]',
                Lt = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top",
                Rt = ".sticky-top",
                Ht = (function () {
                    function e(t, n) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._config = this._getConfig(n)),
                            (this._element = t),
                            (this._dialog = t.querySelector(At)),
                            (this._backdrop = null),
                            (this._isShown = !1),
                            (this._isBodyOverflowing = !1),
                            (this._ignoreBackdropClick = !1),
                            (this._isTransitioning = !1),
                            (this._scrollbarWidth = 0);
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t, n) {
                                        return this.each(function () {
                                            var i = o()(this).data("bs.modal"),
                                                r = pt(pt(pt({}, bt), o()(this).data()), "object" === dt(t) && t ? t : {});
                                            if ((i || ((i = new e(this, r)), o()(this).data("bs.modal", i)), "string" == typeof t)) {
                                                if (void 0 === i[t]) throw new TypeError('No method named "'.concat(t, '"'));
                                                i[t](n);
                                            } else r.show && i.show(n);
                                        });
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return bt;
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "toggle",
                                value: function (e) {
                                    return this._isShown ? this.hide() : this.show(e);
                                },
                            },
                            {
                                key: "show",
                                value: function (e) {
                                    var t = this;
                                    if (!this._isShown && !this._isTransitioning) {
                                        o()(this._element).hasClass(Dt) && (this._isTransitioning = !0);
                                        var n = o.a.Event(wt.SHOW, { relatedTarget: e });
                                        o()(this._element).trigger(n),
                                        this._isShown ||
                                        n.isDefaultPrevented() ||
                                        ((this._isShown = !0),
                                            this._checkScrollbar(),
                                            this._setScrollbar(),
                                            this._adjustDialog(),
                                            this._setEscapeEvent(),
                                            this._setResizeEvent(),
                                            o()(this._element).on(wt.CLICK_DISMISS, Nt, function (e) {
                                                return t.hide(e);
                                            }),
                                            o()(this._dialog).on(wt.MOUSEDOWN_DISMISS, function () {
                                                o()(t._element).one(wt.MOUSEUP_DISMISS, function (e) {
                                                    o()(e.target).is(t._element) && (t._ignoreBackdropClick = !0);
                                                });
                                            }),
                                            this._showBackdrop(function () {
                                                return t._showElement(e);
                                            }));
                                    }
                                },
                            },
                            {
                                key: "hide",
                                value: function (e) {
                                    var t = this;
                                    if ((e && e.preventDefault(), this._isShown && !this._isTransitioning)) {
                                        var n = o.a.Event(wt.HIDE);
                                        if ((o()(this._element).trigger(n), this._isShown && !n.isDefaultPrevented())) {
                                            this._isShown = !1;
                                            var i = o()(this._element).hasClass(Dt);
                                            if (
                                                (i && (this._isTransitioning = !0),
                                                    this._setEscapeEvent(),
                                                    this._setResizeEvent(),
                                                    o()(document).off(wt.FOCUSIN),
                                                    o()(this._element).removeClass(kt),
                                                    o()(this._element).off(wt.CLICK_DISMISS),
                                                    o()(this._dialog).off(wt.MOUSEDOWN_DISMISS),
                                                    i)
                                            ) {
                                                var r = s.getTransitionDurationFromElement(this._element);
                                                o()(this._element)
                                                    .one(s.TRANSITION_END, function (e) {
                                                        return t._hideModal(e);
                                                    })
                                                    .emulateTransitionEnd(r);
                                            } else this._hideModal();
                                        }
                                    }
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    [window, this._element, this._dialog].forEach(function (e) {
                                        return o()(e).off(vt);
                                    }),
                                        o()(document).off(wt.FOCUSIN),
                                        o.a.removeData(this._element, "bs.modal"),
                                        (this._config = null),
                                        (this._element = null),
                                        (this._dialog = null),
                                        (this._backdrop = null),
                                        (this._isShown = null),
                                        (this._isBodyOverflowing = null),
                                        (this._ignoreBackdropClick = null),
                                        (this._isTransitioning = null),
                                        (this._scrollbarWidth = null);
                                },
                            },
                            {
                                key: "handleUpdate",
                                value: function () {
                                    this._adjustDialog();
                                },
                            },
                            {
                                key: "_getConfig",
                                value: function (e) {
                                    return (e = pt(pt({}, bt), e)), s.typeCheckConfig("modal", e, Et), e;
                                },
                            },
                            {
                                key: "_triggerBackdropTransition",
                                value: function () {
                                    var e = this;
                                    if ("static" === this._config.backdrop) {
                                        var t = o.a.Event(wt.HIDE_PREVENTED);
                                        if ((o()(this._element).trigger(t), t.defaultPrevented)) return;
                                        this._element.classList.add(It);
                                        var n = s.getTransitionDurationFromElement(this._element);
                                        o()(this._element)
                                            .one(s.TRANSITION_END, function () {
                                                e._element.classList.remove(It);
                                            })
                                            .emulateTransitionEnd(n),
                                            this._element.focus();
                                    } else this.hide();
                                },
                            },
                            {
                                key: "_showElement",
                                value: function (e) {
                                    var t = this,
                                        n = o()(this._element).hasClass(Dt),
                                        i = this._dialog ? this._dialog.querySelector(jt) : null;
                                    (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE) || document.body.appendChild(this._element),
                                        (this._element.style.display = "block"),
                                        this._element.removeAttribute("aria-hidden"),
                                        this._element.setAttribute("aria-modal", !0),
                                        o()(this._dialog).hasClass(St) && i ? (i.scrollTop = 0) : (this._element.scrollTop = 0),
                                    n && s.reflow(this._element),
                                        o()(this._element).addClass(kt),
                                    this._config.focus && this._enforceFocus();
                                    var r = o.a.Event(wt.SHOWN, { relatedTarget: e }),
                                        a = function () {
                                            t._config.focus && t._element.focus(), (t._isTransitioning = !1), o()(t._element).trigger(r);
                                        };
                                    if (n) {
                                        var l = s.getTransitionDurationFromElement(this._dialog);
                                        o()(this._dialog).one(s.TRANSITION_END, a).emulateTransitionEnd(l);
                                    } else a();
                                },
                            },
                            {
                                key: "_enforceFocus",
                                value: function () {
                                    var e = this;
                                    o()(document)
                                        .off(wt.FOCUSIN)
                                        .on(wt.FOCUSIN, function (t) {
                                            document !== t.target && e._element !== t.target && 0 === o()(e._element).has(t.target).length && e._element.focus();
                                        });
                                },
                            },
                            {
                                key: "_setEscapeEvent",
                                value: function () {
                                    var e = this;
                                    this._isShown && this._config.keyboard
                                        ? o()(this._element).on(wt.KEYDOWN_DISMISS, function (t) {
                                            27 === t.which && e._triggerBackdropTransition();
                                        })
                                        : this._isShown || o()(this._element).off(wt.KEYDOWN_DISMISS);
                                },
                            },
                            {
                                key: "_setResizeEvent",
                                value: function () {
                                    var e = this;
                                    this._isShown
                                        ? o()(window).on(wt.RESIZE, function (t) {
                                            return e.handleUpdate(t);
                                        })
                                        : o()(window).off(wt.RESIZE);
                                },
                            },
                            {
                                key: "_hideModal",
                                value: function () {
                                    var e = this;
                                    (this._element.style.display = "none"),
                                        this._element.setAttribute("aria-hidden", !0),
                                        this._element.removeAttribute("aria-modal"),
                                        (this._isTransitioning = !1),
                                        this._showBackdrop(function () {
                                            o()(document.body).removeClass(Tt), e._resetAdjustments(), e._resetScrollbar(), o()(e._element).trigger(wt.HIDDEN);
                                        });
                                },
                            },
                            {
                                key: "_removeBackdrop",
                                value: function () {
                                    this._backdrop && (o()(this._backdrop).remove(), (this._backdrop = null));
                                },
                            },
                            {
                                key: "_showBackdrop",
                                value: function (e) {
                                    var t = this,
                                        n = o()(this._element).hasClass(Dt) ? Dt : "";
                                    if (this._isShown && this._config.backdrop) {
                                        if (
                                            ((this._backdrop = document.createElement("div")),
                                                (this._backdrop.className = Ot),
                                            n && this._backdrop.classList.add(n),
                                                o()(this._backdrop).appendTo(document.body),
                                                o()(this._element).on(wt.CLICK_DISMISS, function (e) {
                                                    t._ignoreBackdropClick ? (t._ignoreBackdropClick = !1) : e.target === e.currentTarget && t._triggerBackdropTransition();
                                                }),
                                            n && s.reflow(this._backdrop),
                                                o()(this._backdrop).addClass(kt),
                                                !e)
                                        )
                                            return;
                                        if (!n) return void e();
                                        var i = s.getTransitionDurationFromElement(this._backdrop);
                                        o()(this._backdrop).one(s.TRANSITION_END, e).emulateTransitionEnd(i);
                                    } else if (!this._isShown && this._backdrop) {
                                        o()(this._backdrop).removeClass(kt);
                                        var r = function () {
                                            t._removeBackdrop(), e && e();
                                        };
                                        if (o()(this._element).hasClass(Dt)) {
                                            var a = s.getTransitionDurationFromElement(this._backdrop);
                                            o()(this._backdrop).one(s.TRANSITION_END, r).emulateTransitionEnd(a);
                                        } else r();
                                    } else e && e();
                                },
                            },
                            {
                                key: "_adjustDialog",
                                value: function () {
                                    var e = this._element.scrollHeight > document.documentElement.clientHeight;
                                    !this._isBodyOverflowing && e && (this._element.style.paddingLeft = "".concat(this._scrollbarWidth, "px")),
                                    this._isBodyOverflowing && !e && (this._element.style.paddingRight = "".concat(this._scrollbarWidth, "px"));
                                },
                            },
                            {
                                key: "_resetAdjustments",
                                value: function () {
                                    (this._element.style.paddingLeft = ""), (this._element.style.paddingRight = "");
                                },
                            },
                            {
                                key: "_checkScrollbar",
                                value: function () {
                                    var e = document.body.getBoundingClientRect();
                                    (this._isBodyOverflowing = e.left + e.right < window.innerWidth), (this._scrollbarWidth = this._getScrollbarWidth());
                                },
                            },
                            {
                                key: "_setScrollbar",
                                value: function () {
                                    var e = this;
                                    if (this._isBodyOverflowing) {
                                        var t = [].slice.call(document.querySelectorAll(Lt)),
                                            n = [].slice.call(document.querySelectorAll(Rt));
                                        o()(t).each(function (t, n) {
                                            var i = n.style.paddingRight,
                                                r = o()(n).css("padding-right");
                                            o()(n)
                                                .data("padding-right", i)
                                                .css("padding-right", "".concat(parseFloat(r) + e._scrollbarWidth, "px"));
                                        }),
                                            o()(n).each(function (t, n) {
                                                var i = n.style.marginRight,
                                                    r = o()(n).css("margin-right");
                                                o()(n)
                                                    .data("margin-right", i)
                                                    .css("margin-right", "".concat(parseFloat(r) - e._scrollbarWidth, "px"));
                                            });
                                        var i = document.body.style.paddingRight,
                                            r = o()(document.body).css("padding-right");
                                        o()(document.body)
                                            .data("padding-right", i)
                                            .css("padding-right", "".concat(parseFloat(r) + this._scrollbarWidth, "px"));
                                    }
                                    o()(document.body).addClass(Tt);
                                },
                            },
                            {
                                key: "_resetScrollbar",
                                value: function () {
                                    var e = [].slice.call(document.querySelectorAll(Lt));
                                    o()(e).each(function (e, t) {
                                        var n = o()(t).data("padding-right");
                                        o()(t).removeData("padding-right"), (t.style.paddingRight = n || "");
                                    });
                                    var t = [].slice.call(document.querySelectorAll("".concat(Rt)));
                                    o()(t).each(function (e, t) {
                                        var n = o()(t).data("margin-right");
                                        void 0 !== n && o()(t).css("margin-right", n).removeData("margin-right");
                                    });
                                    var n = o()(document.body).data("padding-right");
                                    o()(document.body).removeData("padding-right"), (document.body.style.paddingRight = n || "");
                                },
                            },
                            {
                                key: "_getScrollbarWidth",
                                value: function () {
                                    var e = document.createElement("div");
                                    (e.className = Ct), document.body.appendChild(e);
                                    var t = e.getBoundingClientRect().width - e.clientWidth;
                                    return document.body.removeChild(e), t;
                                },
                            },
                        ]) && _t(t.prototype, n),
                        i && _t(t, i),
                            e
                    );
                })();
            o()(document).on(wt.CLICK_DATA_API, Pt, function (e) {
                var t,
                    n = this,
                    i = s.getSelectorFromElement(this);
                i && (t = document.querySelector(i));
                var r = o()(t).data("bs.modal") ? "toggle" : pt(pt({}, o()(t).data()), o()(this).data());
                ("A" !== this.tagName && "AREA" !== this.tagName) || e.preventDefault();
                var a = o()(t).one(wt.SHOW, function (e) {
                    e.isDefaultPrevented() ||
                    a.one(wt.HIDDEN, function () {
                        o()(n).is(":visible") && n.focus();
                    });
                });
                Ht._jQueryInterface.call(o()(t), r, this);
            }),
                (o.a.fn.modal = Ht._jQueryInterface),
                (o.a.fn.modal.Constructor = Ht),
                (o.a.fn.modal.noConflict = function () {
                    return (o.a.fn.modal = yt), Ht._jQueryInterface;
                });
            var xt = Ht;
            function Ft(e) {
                return (Ft =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                            return typeof e;
                        }
                        : function (e) {
                            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                        })(e);
            }
            function Ut(e, t) {
                var n = Object.keys(e);
                if (Object.getOwnPropertySymbols) {
                    var i = Object.getOwnPropertySymbols(e);
                    t &&
                    (i = i.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                        n.push.apply(n, i);
                }
                return n;
            }
            function Mt(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = null != arguments[t] ? arguments[t] : {};
                    t % 2
                        ? Ut(Object(n), !0).forEach(function (t) {
                            Wt(e, t, n[t]);
                        })
                        : Object.getOwnPropertyDescriptors
                            ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                            : Ut(Object(n)).forEach(function (t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                            });
                }
                return e;
            }
            function Wt(e, t, n) {
                return t in e ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = n), e;
            }
            function qt(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var Kt = ".".concat("bs.scrollspy"),
                Qt = o.a.fn.scrollspy,
                Bt = { offset: 10, method: "auto", target: "" },
                Vt = { offset: "number", method: "string", target: "(string|element)" },
                Yt = { ACTIVATE: "activate".concat(Kt), SCROLL: "scroll".concat(Kt), LOAD_DATA_API: "load".concat(Kt).concat(".data-api") },
                zt = "dropdown-item",
                Xt = "active",
                $t = '[data-spy="scroll"]',
                Gt = ".nav, .list-group",
                Jt = ".nav-link",
                Zt = ".nav-item",
                en = ".list-group-item",
                tn = ".dropdown",
                nn = ".dropdown-item",
                on = ".dropdown-toggle",
                rn = "offset",
                an = "position",
                sn = (function () {
                    function e(t, n) {
                        var i = this;
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._element = t),
                            (this._scrollElement = "BODY" === t.tagName ? window : t),
                            (this._config = this._getConfig(n)),
                            (this._selector = "".concat(this._config.target, " ").concat(Jt, ",") + "".concat(this._config.target, " ").concat(en, ",") + "".concat(this._config.target, " ").concat(nn)),
                            (this._offsets = []),
                            (this._targets = []),
                            (this._activeTarget = null),
                            (this._scrollHeight = 0),
                            o()(this._scrollElement).on(Yt.SCROLL, function (e) {
                                return i._process(e);
                            }),
                            this.refresh(),
                            this._process();
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this).data("bs.scrollspy"),
                                                i = "object" === Ft(t) && t;
                                            if ((n || ((n = new e(this, i)), o()(this).data("bs.scrollspy", n)), "string" == typeof t)) {
                                                if (void 0 === n[t]) throw new TypeError('No method named "'.concat(t, '"'));
                                                n[t]();
                                            }
                                        });
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return Bt;
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "refresh",
                                value: function () {
                                    var e = this,
                                        t = this._scrollElement === this._scrollElement.window ? rn : an,
                                        n = "auto" === this._config.method ? t : this._config.method,
                                        i = n === an ? this._getScrollTop() : 0;
                                    (this._offsets = []),
                                        (this._targets = []),
                                        (this._scrollHeight = this._getScrollHeight()),
                                        [].slice
                                            .call(document.querySelectorAll(this._selector))
                                            .map(function (e) {
                                                var t,
                                                    r = s.getSelectorFromElement(e);
                                                if ((r && (t = document.querySelector(r)), t)) {
                                                    var a = t.getBoundingClientRect();
                                                    if (a.width || a.height) return [o()(t)[n]().top + i, r];
                                                }
                                                return null;
                                            })
                                            .filter(function (e) {
                                                return e;
                                            })
                                            .sort(function (e, t) {
                                                return e[0] - t[0];
                                            })
                                            .forEach(function (t) {
                                                e._offsets.push(t[0]), e._targets.push(t[1]);
                                            });
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    o.a.removeData(this._element, "bs.scrollspy"),
                                        o()(this._scrollElement).off(Kt),
                                        (this._element = null),
                                        (this._scrollElement = null),
                                        (this._config = null),
                                        (this._selector = null),
                                        (this._offsets = null),
                                        (this._targets = null),
                                        (this._activeTarget = null),
                                        (this._scrollHeight = null);
                                },
                            },
                            {
                                key: "_getConfig",
                                value: function (e) {
                                    if ("string" != typeof (e = Mt(Mt({}, Bt), "object" === Ft(e) && e ? e : {})).target) {
                                        var t = o()(e.target).attr("id");
                                        t || ((t = s.getUID("scrollspy")), o()(e.target).attr("id", t)), (e.target = "#".concat(t));
                                    }
                                    return s.typeCheckConfig("scrollspy", e, Vt), e;
                                },
                            },
                            {
                                key: "_getScrollTop",
                                value: function () {
                                    return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop;
                                },
                            },
                            {
                                key: "_getScrollHeight",
                                value: function () {
                                    return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
                                },
                            },
                            {
                                key: "_getOffsetHeight",
                                value: function () {
                                    return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height;
                                },
                            },
                            {
                                key: "_process",
                                value: function () {
                                    var e = this._getScrollTop() + this._config.offset,
                                        t = this._getScrollHeight(),
                                        n = this._config.offset + t - this._getOffsetHeight();
                                    if ((this._scrollHeight !== t && this.refresh(), e >= n)) {
                                        var i = this._targets[this._targets.length - 1];
                                        this._activeTarget !== i && this._activate(i);
                                    } else {
                                        if (this._activeTarget && e < this._offsets[0] && this._offsets[0] > 0) return (this._activeTarget = null), void this._clear();
                                        for (var o = this._offsets.length; o--; )
                                            this._activeTarget !== this._targets[o] && e >= this._offsets[o] && (void 0 === this._offsets[o + 1] || e < this._offsets[o + 1]) && this._activate(this._targets[o]);
                                    }
                                },
                            },
                            {
                                key: "_activate",
                                value: function (e) {
                                    (this._activeTarget = e), this._clear();
                                    var t = this._selector.split(",").map(function (t) {
                                            return "".concat(t, '[data-target="').concat(e, '"],').concat(t, '[href="').concat(e, '"]');
                                        }),
                                        n = o()([].slice.call(document.querySelectorAll(t.join(","))));
                                    n.hasClass(zt)
                                        ? (n.closest(tn).find(on).addClass(Xt), n.addClass(Xt))
                                        : (n.addClass(Xt), n.parents(Gt).prev("".concat(Jt, ", ").concat(en)).addClass(Xt), n.parents(Gt).prev(Zt).children(Jt).addClass(Xt)),
                                        o()(this._scrollElement).trigger(Yt.ACTIVATE, { relatedTarget: e });
                                },
                            },
                            {
                                key: "_clear",
                                value: function () {
                                    [].slice
                                        .call(document.querySelectorAll(this._selector))
                                        .filter(function (e) {
                                            return e.classList.contains(Xt);
                                        })
                                        .forEach(function (e) {
                                            return e.classList.remove(Xt);
                                        });
                                },
                            },
                        ]) && qt(t.prototype, n),
                        i && qt(t, i),
                            e
                    );
                })();
            o()(window).on(Yt.LOAD_DATA_API, function () {
                for (var e = [].slice.call(document.querySelectorAll($t)), t = e.length; t--; ) {
                    var n = o()(e[t]);
                    sn._jQueryInterface.call(n, n.data());
                }
            }),
                (o.a.fn.scrollspy = sn._jQueryInterface),
                (o.a.fn.scrollspy.Constructor = sn),
                (o.a.fn.scrollspy.noConflict = function () {
                    return (o.a.fn.scrollspy = Qt), sn._jQueryInterface;
                });
            var ln = sn;
            function cn(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var un = ".".concat("bs.tab"),
                fn = o.a.fn.tab,
                hn = { HIDE: "hide".concat(un), HIDDEN: "hidden".concat(un), SHOW: "show".concat(un), SHOWN: "shown".concat(un), CLICK_DATA_API: "click".concat(un).concat(".data-api") },
                dn = "dropdown-menu",
                gn = "active",
                pn = "disabled",
                mn = "fade",
                _n = "show",
                vn = ".dropdown",
                yn = ".nav, .list-group",
                bn = ".active",
                En = "> li > .active",
                wn = '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]',
                Sn = ".dropdown-toggle",
                Cn = "> .dropdown-menu .active",
                On = (function () {
                    function e(t) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._element = t);
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this),
                                                i = n.data("bs.tab");
                                            if ((i || ((i = new e(this)), n.data("bs.tab", i)), "string" == typeof t)) {
                                                if (void 0 === i[t]) throw new TypeError('No method named "'.concat(t, '"'));
                                                i[t]();
                                            }
                                        });
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "show",
                                value: function () {
                                    var e = this;
                                    if (!((this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && o()(this._element).hasClass(gn)) || o()(this._element).hasClass(pn))) {
                                        var t,
                                            n,
                                            i = o()(this._element).closest(yn)[0],
                                            r = s.getSelectorFromElement(this._element);
                                        if (i) {
                                            var a = "UL" === i.nodeName || "OL" === i.nodeName ? En : bn;
                                            n = (n = o.a.makeArray(o()(i).find(a)))[n.length - 1];
                                        }
                                        var l = o.a.Event(hn.HIDE, { relatedTarget: this._element }),
                                            c = o.a.Event(hn.SHOW, { relatedTarget: n });
                                        if ((n && o()(n).trigger(l), o()(this._element).trigger(c), !c.isDefaultPrevented() && !l.isDefaultPrevented())) {
                                            r && (t = document.querySelector(r)), this._activate(this._element, i);
                                            var u = function () {
                                                var t = o.a.Event(hn.HIDDEN, { relatedTarget: e._element }),
                                                    i = o.a.Event(hn.SHOWN, { relatedTarget: n });
                                                o()(n).trigger(t), o()(e._element).trigger(i);
                                            };
                                            t ? this._activate(t, t.parentNode, u) : u();
                                        }
                                    }
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    o.a.removeData(this._element, "bs.tab"), (this._element = null);
                                },
                            },
                            {
                                key: "_activate",
                                value: function (e, t, n) {
                                    var i = this,
                                        r = (!t || ("UL" !== t.nodeName && "OL" !== t.nodeName) ? o()(t).children(bn) : o()(t).find(En))[0],
                                        a = n && r && o()(r).hasClass(mn),
                                        l = function () {
                                            return i._transitionComplete(e, r, n);
                                        };
                                    if (r && a) {
                                        var c = s.getTransitionDurationFromElement(r);
                                        o()(r).removeClass(_n).one(s.TRANSITION_END, l).emulateTransitionEnd(c);
                                    } else l();
                                },
                            },
                            {
                                key: "_transitionComplete",
                                value: function (e, t, n) {
                                    if (t) {
                                        o()(t).removeClass(gn);
                                        var i = o()(t.parentNode).find(Cn)[0];
                                        i && o()(i).removeClass(gn), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !1);
                                    }
                                    if (
                                        (o()(e).addClass(gn),
                                        "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !0),
                                            s.reflow(e),
                                        e.classList.contains(mn) && e.classList.add(_n),
                                        e.parentNode && o()(e.parentNode).hasClass(dn))
                                    ) {
                                        var r = o()(e).closest(vn)[0];
                                        if (r) {
                                            var a = [].slice.call(r.querySelectorAll(Sn));
                                            o()(a).addClass(gn);
                                        }
                                        e.setAttribute("aria-expanded", !0);
                                    }
                                    n && n();
                                },
                            },
                        ]) && cn(t.prototype, n),
                        i && cn(t, i),
                            e
                    );
                })();
            o()(document).on(hn.CLICK_DATA_API, wn, function (e) {
                e.preventDefault(), On._jQueryInterface.call(o()(this), "show");
            }),
                (o.a.fn.tab = On._jQueryInterface),
                (o.a.fn.tab.Constructor = On),
                (o.a.fn.tab.noConflict = function () {
                    return (o.a.fn.tab = fn), On._jQueryInterface;
                });
            var Tn = On;
            function Dn(e) {
                return (Dn =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                            return typeof e;
                        }
                        : function (e) {
                            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                        })(e);
            }
            function kn(e, t) {
                var n = Object.keys(e);
                if (Object.getOwnPropertySymbols) {
                    var i = Object.getOwnPropertySymbols(e);
                    t &&
                    (i = i.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                        n.push.apply(n, i);
                }
                return n;
            }
            function In(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = null != arguments[t] ? arguments[t] : {};
                    t % 2
                        ? kn(Object(n), !0).forEach(function (t) {
                            An(e, t, n[t]);
                        })
                        : Object.getOwnPropertyDescriptors
                            ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                            : kn(Object(n)).forEach(function (t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                            });
                }
                return e;
            }
            function An(e, t, n) {
                return t in e ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = n), e;
            }
            function jn(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var Pn = ".".concat("bs.toast"),
                Nn = o.a.fn.toast,
                Ln = { CLICK_DISMISS: "click.dismiss".concat(Pn), HIDE: "hide".concat(Pn), HIDDEN: "hidden".concat(Pn), SHOW: "show".concat(Pn), SHOWN: "shown".concat(Pn) },
                Rn = "fade",
                Hn = "hide",
                xn = "show",
                Fn = "showing",
                Un = { animation: "boolean", autohide: "boolean", delay: "number" },
                Mn = { animation: !0, autohide: !0, delay: 500 },
                Wn = '[data-dismiss="toast"]',
                qn = (function () {
                    function e(t, n) {
                        !(function (e, t) {
                            if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                        })(this, e),
                            (this._element = t),
                            (this._config = this._getConfig(n)),
                            (this._timeout = null),
                            this._setListeners();
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this),
                                                i = n.data("bs.toast"),
                                                r = "object" === Dn(t) && t;
                                            if ((i || ((i = new e(this, r)), n.data("bs.toast", i)), "string" == typeof t)) {
                                                if (void 0 === i[t]) throw new TypeError('No method named "'.concat(t, '"'));
                                                i[t](this);
                                            }
                                        });
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                                {
                                    key: "DefaultType",
                                    get: function () {
                                        return Un;
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return Mn;
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "show",
                                value: function () {
                                    var e = this,
                                        t = o.a.Event(Ln.SHOW);
                                    if ((o()(this._element).trigger(t), !t.isDefaultPrevented())) {
                                        this._config.animation && this._element.classList.add(Rn);
                                        var n = function () {
                                            e._element.classList.remove(Fn),
                                                e._element.classList.add(xn),
                                                o()(e._element).trigger(Ln.SHOWN),
                                            e._config.autohide &&
                                            (e._timeout = setTimeout(function () {
                                                e.hide();
                                            }, e._config.delay));
                                        };
                                        if ((this._element.classList.remove(Hn), s.reflow(this._element), this._element.classList.add(Fn), this._config.animation)) {
                                            var i = s.getTransitionDurationFromElement(this._element);
                                            o()(this._element).one(s.TRANSITION_END, n).emulateTransitionEnd(i);
                                        } else n();
                                    }
                                },
                            },
                            {
                                key: "hide",
                                value: function () {
                                    if (this._element.classList.contains(xn)) {
                                        var e = o.a.Event(Ln.HIDE);
                                        o()(this._element).trigger(e), e.isDefaultPrevented() || this._close();
                                    }
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    clearTimeout(this._timeout),
                                        (this._timeout = null),
                                    this._element.classList.contains(xn) && this._element.classList.remove(xn),
                                        o()(this._element).off(Ln.CLICK_DISMISS),
                                        o.a.removeData(this._element, "bs.toast"),
                                        (this._element = null),
                                        (this._config = null);
                                },
                            },
                            {
                                key: "_getConfig",
                                value: function (e) {
                                    return (e = In(In(In({}, Mn), o()(this._element).data()), "object" === Dn(e) && e ? e : {})), s.typeCheckConfig("toast", e, this.constructor.DefaultType), e;
                                },
                            },
                            {
                                key: "_setListeners",
                                value: function () {
                                    var e = this;
                                    o()(this._element).on(Ln.CLICK_DISMISS, Wn, function () {
                                        return e.hide();
                                    });
                                },
                            },
                            {
                                key: "_close",
                                value: function () {
                                    var e = this,
                                        t = function () {
                                            e._element.classList.add(Hn), o()(e._element).trigger(Ln.HIDDEN);
                                        };
                                    if ((this._element.classList.remove(xn), this._config.animation)) {
                                        var n = s.getTransitionDurationFromElement(this._element);
                                        o()(this._element).one(s.TRANSITION_END, t).emulateTransitionEnd(n);
                                    } else t();
                                },
                            },
                        ]) && jn(t.prototype, n),
                        i && jn(t, i),
                            e
                    );
                })();
            (o.a.fn.toast = qn._jQueryInterface),
                (o.a.fn.toast.Constructor = qn),
                (o.a.fn.toast.noConflict = function () {
                    return (o.a.fn.toast = Nn), qn._jQueryInterface;
                });
            var Kn = qn,
                Qn = ["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"],
                Bn = {
                    "*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i],
                    a: ["target", "href", "title", "rel"],
                    area: [],
                    b: [],
                    br: [],
                    col: [],
                    code: [],
                    div: [],
                    em: [],
                    hr: [],
                    h1: [],
                    h2: [],
                    h3: [],
                    h4: [],
                    h5: [],
                    h6: [],
                    i: [],
                    img: ["src", "alt", "title", "width", "height"],
                    li: [],
                    ol: [],
                    p: [],
                    pre: [],
                    s: [],
                    small: [],
                    span: [],
                    sub: [],
                    sup: [],
                    strong: [],
                    u: [],
                    ul: [],
                },
                Vn = /^(?:(?:https?|mailto|ftp|tel|file):|[^&:/?#]*(?:[/?#]|$))/gi,
                Yn = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[a-z0-9+/]+=*$/i;
            function zn(e, t, n) {
                if (0 === e.length) return e;
                if (n && "function" == typeof n) return n(e);
                for (
                    var i = new window.DOMParser().parseFromString(e, "text/html"),
                        o = Object.keys(t),
                        r = [].slice.call(i.body.querySelectorAll("*")),
                        a = function (e, n) {
                            var i = r[e],
                                a = i.nodeName.toLowerCase();
                            if (-1 === o.indexOf(i.nodeName.toLowerCase())) return i.parentNode.removeChild(i), "continue";
                            var s = [].slice.call(i.attributes),
                                l = [].concat(t["*"] || [], t[a] || []);
                            s.forEach(function (e) {
                                (function (e, t) {
                                    var n = e.nodeName.toLowerCase();
                                    if (-1 !== t.indexOf(n)) return -1 === Qn.indexOf(n) || Boolean(e.nodeValue.match(Vn) || e.nodeValue.match(Yn));
                                    for (
                                        var i = t.filter(function (e) {
                                                return e instanceof RegExp;
                                            }),
                                            o = 0,
                                            r = i.length;
                                        o < r;
                                        o++
                                    )
                                        if (n.match(i[o])) return !0;
                                    return !1;
                                })(e, l) || i.removeAttribute(e.nodeName);
                            });
                        },
                        s = 0,
                        l = r.length;
                    s < l;
                    s++
                )
                    a(s);
                return i.body.innerHTML;
            }
            function Xn(e, t) {
                var n = Object.keys(e);
                if (Object.getOwnPropertySymbols) {
                    var i = Object.getOwnPropertySymbols(e);
                    t &&
                    (i = i.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                        n.push.apply(n, i);
                }
                return n;
            }
            function $n(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = null != arguments[t] ? arguments[t] : {};
                    t % 2
                        ? Xn(Object(n), !0).forEach(function (t) {
                            Gn(e, t, n[t]);
                        })
                        : Object.getOwnPropertyDescriptors
                            ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                            : Xn(Object(n)).forEach(function (t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                            });
                }
                return e;
            }
            function Gn(e, t, n) {
                return t in e ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = n), e;
            }
            function Jn(e) {
                return (Jn =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                            return typeof e;
                        }
                        : function (e) {
                            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                        })(e);
            }
            function Zn(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            var ei = ".".concat("bs.tooltip"),
                ti = o.a.fn.tooltip,
                ni = new RegExp("(^|\\s)".concat("bs-tooltip", "\\S+"), "g"),
                ii = ["sanitize", "whiteList", "sanitizeFn"],
                oi = {
                    animation: "boolean",
                    template: "string",
                    title: "(string|element|function)",
                    trigger: "string",
                    delay: "(number|object)",
                    html: "boolean",
                    selector: "(string|boolean)",
                    placement: "(string|function)",
                    offset: "(number|string|function)",
                    container: "(string|element|boolean)",
                    fallbackPlacement: "(string|array)",
                    boundary: "(string|element)",
                    sanitize: "boolean",
                    sanitizeFn: "(null|function)",
                    whiteList: "object",
                    popperConfig: "(null|object)",
                },
                ri = { AUTO: "auto", TOP: "top", RIGHT: "right", BOTTOM: "bottom", LEFT: "left" },
                ai = {
                    animation: !0,
                    template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>',
                    trigger: "hover focus",
                    title: "",
                    delay: 0,
                    html: !1,
                    selector: !1,
                    placement: "top",
                    offset: 0,
                    container: !1,
                    fallbackPlacement: "flip",
                    boundary: "scrollParent",
                    sanitize: !0,
                    sanitizeFn: null,
                    whiteList: Bn,
                    popperConfig: null,
                },
                si = "show",
                li = "out",
                ci = {
                    HIDE: "hide".concat(ei),
                    HIDDEN: "hidden".concat(ei),
                    SHOW: "show".concat(ei),
                    SHOWN: "shown".concat(ei),
                    INSERTED: "inserted".concat(ei),
                    CLICK: "click".concat(ei),
                    FOCUSIN: "focusin".concat(ei),
                    FOCUSOUT: "focusout".concat(ei),
                    MOUSEENTER: "mouseenter".concat(ei),
                    MOUSELEAVE: "mouseleave".concat(ei),
                },
                ui = "fade",
                fi = "show",
                hi = ".tooltip-inner",
                di = ".arrow",
                gi = "hover",
                pi = "focus",
                mi = "click",
                _i = "manual",
                vi = (function () {
                    function e(t, n) {
                        if (
                            ((function (e, t) {
                                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
                            })(this, e),
                            void 0 === Re.a)
                        )
                            throw new TypeError("Bootstrap's tooltips require Popper.js (https://popper.js.org/)");
                        (this._isEnabled = !0),
                            (this._timeout = 0),
                            (this._hoverState = ""),
                            (this._activeTrigger = {}),
                            (this._popper = null),
                            (this.element = t),
                            (this.config = this._getConfig(n)),
                            (this.tip = null),
                            this._setListeners();
                    }
                    var t, n, i;
                    return (
                        (t = e),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (t) {
                                        return this.each(function () {
                                            var n = o()(this).data("bs.tooltip"),
                                                i = "object" === Jn(t) && t;
                                            if ((n || !/dispose|hide/.test(t)) && (n || ((n = new e(this, i)), o()(this).data("bs.tooltip", n)), "string" == typeof t)) {
                                                if (void 0 === n[t]) throw new TypeError('No method named "'.concat(t, '"'));
                                                n[t]();
                                            }
                                        });
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return ai;
                                    },
                                },
                                {
                                    key: "NAME",
                                    get: function () {
                                        return "tooltip";
                                    },
                                },
                                {
                                    key: "DATA_KEY",
                                    get: function () {
                                        return "bs.tooltip";
                                    },
                                },
                                {
                                    key: "Event",
                                    get: function () {
                                        return ci;
                                    },
                                },
                                {
                                    key: "EVENT_KEY",
                                    get: function () {
                                        return ei;
                                    },
                                },
                                {
                                    key: "DefaultType",
                                    get: function () {
                                        return oi;
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "enable",
                                value: function () {
                                    this._isEnabled = !0;
                                },
                            },
                            {
                                key: "disable",
                                value: function () {
                                    this._isEnabled = !1;
                                },
                            },
                            {
                                key: "toggleEnabled",
                                value: function () {
                                    this._isEnabled = !this._isEnabled;
                                },
                            },
                            {
                                key: "toggle",
                                value: function (e) {
                                    if (this._isEnabled)
                                        if (e) {
                                            var t = this.constructor.DATA_KEY,
                                                n = o()(e.currentTarget).data(t);
                                            n || ((n = new this.constructor(e.currentTarget, this._getDelegateConfig())), o()(e.currentTarget).data(t, n)),
                                                (n._activeTrigger.click = !n._activeTrigger.click),
                                                n._isWithActiveTrigger() ? n._enter(null, n) : n._leave(null, n);
                                        } else {
                                            if (o()(this.getTipElement()).hasClass(fi)) return void this._leave(null, this);
                                            this._enter(null, this);
                                        }
                                },
                            },
                            {
                                key: "dispose",
                                value: function () {
                                    clearTimeout(this._timeout),
                                        o.a.removeData(this.element, this.constructor.DATA_KEY),
                                        o()(this.element).off(this.constructor.EVENT_KEY),
                                        o()(this.element).closest(".modal").off("hide.bs.modal", this._hideModalHandler),
                                    this.tip && o()(this.tip).remove(),
                                        (this._isEnabled = null),
                                        (this._timeout = null),
                                        (this._hoverState = null),
                                        (this._activeTrigger = null),
                                    this._popper && this._popper.destroy(),
                                        (this._popper = null),
                                        (this.element = null),
                                        (this.config = null),
                                        (this.tip = null);
                                },
                            },
                            {
                                key: "show",
                                value: function () {
                                    var e = this;
                                    if ("none" === o()(this.element).css("display")) throw new Error("Please use show on visible elements");
                                    var t = o.a.Event(this.constructor.Event.SHOW);
                                    if (this.isWithContent() && this._isEnabled) {
                                        o()(this.element).trigger(t);
                                        var n = s.findShadowRoot(this.element),
                                            i = o.a.contains(null !== n ? n : this.element.ownerDocument.documentElement, this.element);
                                        if (t.isDefaultPrevented() || !i) return;
                                        var r = this.getTipElement(),
                                            a = s.getUID(this.constructor.NAME);
                                        r.setAttribute("id", a), this.element.setAttribute("aria-describedby", a), this.setContent(), this.config.animation && o()(r).addClass(ui);
                                        var l = "function" == typeof this.config.placement ? this.config.placement.call(this, r, this.element) : this.config.placement,
                                            c = this._getAttachment(l);
                                        this.addAttachmentClass(c);
                                        var u = this._getContainer();
                                        o()(r).data(this.constructor.DATA_KEY, this),
                                        o.a.contains(this.element.ownerDocument.documentElement, this.tip) || o()(r).appendTo(u),
                                            o()(this.element).trigger(this.constructor.Event.INSERTED),
                                            (this._popper = new Re.a(this.element, r, this._getPopperConfig(c))),
                                            o()(r).addClass(fi),
                                        "ontouchstart" in document.documentElement && o()(document.body).children().on("mouseover", null, o.a.noop);
                                        var f = function () {
                                            e.config.animation && e._fixTransition();
                                            var t = e._hoverState;
                                            (e._hoverState = null), o()(e.element).trigger(e.constructor.Event.SHOWN), t === li && e._leave(null, e);
                                        };
                                        if (o()(this.tip).hasClass(ui)) {
                                            var h = s.getTransitionDurationFromElement(this.tip);
                                            o()(this.tip).one(s.TRANSITION_END, f).emulateTransitionEnd(h);
                                        } else f();
                                    }
                                },
                            },
                            {
                                key: "hide",
                                value: function (e) {
                                    var t = this,
                                        n = this.getTipElement(),
                                        i = o.a.Event(this.constructor.Event.HIDE),
                                        r = function () {
                                            t._hoverState !== si && n.parentNode && n.parentNode.removeChild(n),
                                                t._cleanTipClass(),
                                                t.element.removeAttribute("aria-describedby"),
                                                o()(t.element).trigger(t.constructor.Event.HIDDEN),
                                            null !== t._popper && t._popper.destroy(),
                                            e && e();
                                        };
                                    if ((o()(this.element).trigger(i), !i.isDefaultPrevented())) {
                                        if (
                                            (o()(n).removeClass(fi),
                                            "ontouchstart" in document.documentElement && o()(document.body).children().off("mouseover", null, o.a.noop),
                                                (this._activeTrigger[mi] = !1),
                                                (this._activeTrigger[pi] = !1),
                                                (this._activeTrigger[gi] = !1),
                                                o()(this.tip).hasClass(ui))
                                        ) {
                                            var a = s.getTransitionDurationFromElement(n);
                                            o()(n).one(s.TRANSITION_END, r).emulateTransitionEnd(a);
                                        } else r();
                                        this._hoverState = "";
                                    }
                                },
                            },
                            {
                                key: "update",
                                value: function () {
                                    null !== this._popper && this._popper.scheduleUpdate();
                                },
                            },
                            {
                                key: "isWithContent",
                                value: function () {
                                    return Boolean(this.getTitle());
                                },
                            },
                            {
                                key: "addAttachmentClass",
                                value: function (e) {
                                    o()(this.getTipElement()).addClass("".concat("bs-tooltip", "-").concat(e));
                                },
                            },
                            {
                                key: "getTipElement",
                                value: function () {
                                    return (this.tip = this.tip || o()(this.config.template)[0]), this.tip;
                                },
                            },
                            {
                                key: "setContent",
                                value: function () {
                                    var e = this.getTipElement();
                                    this.setElementContent(o()(e.querySelectorAll(hi)), this.getTitle()), o()(e).removeClass("".concat(ui, " ").concat(fi));
                                },
                            },
                            {
                                key: "setElementContent",
                                value: function (e, t) {
                                    "object" !== Jn(t) || (!t.nodeType && !t.jquery)
                                        ? this.config.html
                                            ? (this.config.sanitize && (t = zn(t, this.config.whiteList, this.config.sanitizeFn)), e.html(t))
                                            : e.text(t)
                                        : this.config.html
                                            ? o()(t).parent().is(e) || e.empty().append(t)
                                            : e.text(o()(t).text());
                                },
                            },
                            {
                                key: "getTitle",
                                value: function () {
                                    var e = this.element.getAttribute("data-original-title");
                                    return e || (e = "function" == typeof this.config.title ? this.config.title.call(this.element) : this.config.title), e;
                                },
                            },
                            {
                                key: "_getPopperConfig",
                                value: function (e) {
                                    var t = this;
                                    return $n(
                                        $n(
                                            {},
                                            {
                                                placement: e,
                                                modifiers: { offset: this._getOffset(), flip: { behavior: this.config.fallbackPlacement }, arrow: { element: di }, preventOverflow: { boundariesElement: this.config.boundary } },
                                                onCreate: function (e) {
                                                    e.originalPlacement !== e.placement && t._handlePopperPlacementChange(e);
                                                },
                                                onUpdate: function (e) {
                                                    return t._handlePopperPlacementChange(e);
                                                },
                                            }
                                        ),
                                        this.config.popperConfig
                                    );
                                },
                            },
                            {
                                key: "_getOffset",
                                value: function () {
                                    var e = this,
                                        t = {};
                                    return (
                                        "function" == typeof this.config.offset
                                            ? (t.fn = function (t) {
                                                return (t.offsets = $n($n({}, t.offsets), e.config.offset(t.offsets, e.element) || {})), t;
                                            })
                                            : (t.offset = this.config.offset),
                                            t
                                    );
                                },
                            },
                            {
                                key: "_getContainer",
                                value: function () {
                                    return !1 === this.config.container ? document.body : s.isElement(this.config.container) ? o()(this.config.container) : o()(document).find(this.config.container);
                                },
                            },
                            {
                                key: "_getAttachment",
                                value: function (e) {
                                    return ri[e.toUpperCase()];
                                },
                            },
                            {
                                key: "_setListeners",
                                value: function () {
                                    var e = this;
                                    this.config.trigger.split(" ").forEach(function (t) {
                                        if ("click" === t)
                                            o()(e.element).on(e.constructor.Event.CLICK, e.config.selector, function (t) {
                                                return e.toggle(t);
                                            });
                                        else if (t !== _i) {
                                            var n = t === gi ? e.constructor.Event.MOUSEENTER : e.constructor.Event.FOCUSIN,
                                                i = t === gi ? e.constructor.Event.MOUSELEAVE : e.constructor.Event.FOCUSOUT;
                                            o()(e.element)
                                                .on(n, e.config.selector, function (t) {
                                                    return e._enter(t);
                                                })
                                                .on(i, e.config.selector, function (t) {
                                                    return e._leave(t);
                                                });
                                        }
                                    }),
                                        (this._hideModalHandler = function () {
                                            e.element && e.hide();
                                        }),
                                        o()(this.element).closest(".modal").on("hide.bs.modal", this._hideModalHandler),
                                        this.config.selector ? (this.config = $n($n({}, this.config), {}, { trigger: "manual", selector: "" })) : this._fixTitle();
                                },
                            },
                            {
                                key: "_fixTitle",
                                value: function () {
                                    var e = Jn(this.element.getAttribute("data-original-title"));
                                    (this.element.getAttribute("title") || "string" !== e) && (this.element.setAttribute("data-original-title", this.element.getAttribute("title") || ""), this.element.setAttribute("title", ""));
                                },
                            },
                            {
                                key: "_enter",
                                value: function (e, t) {
                                    var n = this.constructor.DATA_KEY;
                                    (t = t || o()(e.currentTarget).data(n)) || ((t = new this.constructor(e.currentTarget, this._getDelegateConfig())), o()(e.currentTarget).data(n, t)),
                                    e && (t._activeTrigger["focusin" === e.type ? pi : gi] = !0),
                                        o()(t.getTipElement()).hasClass(fi) || t._hoverState === si
                                            ? (t._hoverState = si)
                                            : (clearTimeout(t._timeout),
                                                (t._hoverState = si),
                                                t.config.delay && t.config.delay.show
                                                    ? (t._timeout = setTimeout(function () {
                                                        t._hoverState === si && t.show();
                                                    }, t.config.delay.show))
                                                    : t.show());
                                },
                            },
                            {
                                key: "_leave",
                                value: function (e, t) {
                                    var n = this.constructor.DATA_KEY;
                                    (t = t || o()(e.currentTarget).data(n)) || ((t = new this.constructor(e.currentTarget, this._getDelegateConfig())), o()(e.currentTarget).data(n, t)),
                                    e && (t._activeTrigger["focusout" === e.type ? pi : gi] = !1),
                                    t._isWithActiveTrigger() ||
                                    (clearTimeout(t._timeout),
                                        (t._hoverState = li),
                                        t.config.delay && t.config.delay.hide
                                            ? (t._timeout = setTimeout(function () {
                                                t._hoverState === li && t.hide();
                                            }, t.config.delay.hide))
                                            : t.hide());
                                },
                            },
                            {
                                key: "_isWithActiveTrigger",
                                value: function () {
                                    for (var e in this._activeTrigger) if (this._activeTrigger[e]) return !0;
                                    return !1;
                                },
                            },
                            {
                                key: "_getConfig",
                                value: function (e) {
                                    var t = o()(this.element).data();
                                    return (
                                        Object.keys(t).forEach(function (e) {
                                            -1 !== ii.indexOf(e) && delete t[e];
                                        }),
                                        "number" == typeof (e = $n($n($n({}, this.constructor.Default), t), "object" === Jn(e) && e ? e : {})).delay && (e.delay = { show: e.delay, hide: e.delay }),
                                        "number" == typeof e.title && (e.title = e.title.toString()),
                                        "number" == typeof e.content && (e.content = e.content.toString()),
                                            s.typeCheckConfig("tooltip", e, this.constructor.DefaultType),
                                        e.sanitize && (e.template = zn(e.template, e.whiteList, e.sanitizeFn)),
                                            e
                                    );
                                },
                            },
                            {
                                key: "_getDelegateConfig",
                                value: function () {
                                    var e = {};
                                    if (this.config) for (var t in this.config) this.constructor.Default[t] !== this.config[t] && (e[t] = this.config[t]);
                                    return e;
                                },
                            },
                            {
                                key: "_cleanTipClass",
                                value: function () {
                                    var e = o()(this.getTipElement()),
                                        t = e.attr("class").match(ni);
                                    null !== t && t.length && e.removeClass(t.join(""));
                                },
                            },
                            {
                                key: "_handlePopperPlacementChange",
                                value: function (e) {
                                    var t = e.instance;
                                    (this.tip = t.popper), this._cleanTipClass(), this.addAttachmentClass(this._getAttachment(e.placement));
                                },
                            },
                            {
                                key: "_fixTransition",
                                value: function () {
                                    var e = this.getTipElement(),
                                        t = this.config.animation;
                                    null === e.getAttribute("x-placement") && (o()(e).removeClass(ui), (this.config.animation = !1), this.hide(), this.show(), (this.config.animation = t));
                                },
                            },
                        ]) && Zn(t.prototype, n),
                        i && Zn(t, i),
                            e
                    );
                })();
            (o.a.fn.tooltip = vi._jQueryInterface),
                (o.a.fn.tooltip.Constructor = vi),
                (o.a.fn.tooltip.noConflict = function () {
                    return (o.a.fn.tooltip = ti), vi._jQueryInterface;
                });
            var yi = vi;
            function bi(e) {
                return (bi =
                    "function" == typeof Symbol && "symbol" == typeof Symbol.iterator
                        ? function (e) {
                            return typeof e;
                        }
                        : function (e) {
                            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e;
                        })(e);
            }
            function Ei(e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
            }
            function wi(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var i = t[n];
                    (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
                }
            }
            function Si(e, t) {
                return (Si =
                    Object.setPrototypeOf ||
                    function (e, t) {
                        return (e.__proto__ = t), e;
                    })(e, t);
            }
            function Ci(e) {
                var t = (function () {
                    if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
                    if (Reflect.construct.sham) return !1;
                    if ("function" == typeof Proxy) return !0;
                    try {
                        return Date.prototype.toString.call(Reflect.construct(Date, [], function () {})), !0;
                    } catch (e) {
                        return !1;
                    }
                })();
                return function () {
                    var n,
                        i = Ti(e);
                    if (t) {
                        var o = Ti(this).constructor;
                        n = Reflect.construct(i, arguments, o);
                    } else n = i.apply(this, arguments);
                    return Oi(this, n);
                };
            }
            function Oi(e, t) {
                return !t || ("object" !== bi(t) && "function" != typeof t)
                    ? (function (e) {
                        if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                        return e;
                    })(e)
                    : t;
            }
            function Ti(e) {
                return (Ti = Object.setPrototypeOf
                    ? Object.getPrototypeOf
                    : function (e) {
                        return e.__proto__ || Object.getPrototypeOf(e);
                    })(e);
            }
            function Di(e, t) {
                var n = Object.keys(e);
                if (Object.getOwnPropertySymbols) {
                    var i = Object.getOwnPropertySymbols(e);
                    t &&
                    (i = i.filter(function (t) {
                        return Object.getOwnPropertyDescriptor(e, t).enumerable;
                    })),
                        n.push.apply(n, i);
                }
                return n;
            }
            function ki(e) {
                for (var t = 1; t < arguments.length; t++) {
                    var n = null != arguments[t] ? arguments[t] : {};
                    t % 2
                        ? Di(Object(n), !0).forEach(function (t) {
                            Ii(e, t, n[t]);
                        })
                        : Object.getOwnPropertyDescriptors
                            ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(n))
                            : Di(Object(n)).forEach(function (t) {
                                Object.defineProperty(e, t, Object.getOwnPropertyDescriptor(n, t));
                            });
                }
                return e;
            }
            function Ii(e, t, n) {
                return t in e ? Object.defineProperty(e, t, { value: n, enumerable: !0, configurable: !0, writable: !0 }) : (e[t] = n), e;
            }
            var Ai = ".".concat("bs.popover"),
                ji = o.a.fn.popover,
                Pi = new RegExp("(^|\\s)".concat("bs-popover", "\\S+"), "g"),
                Ni = ki(
                    ki({}, yi.Default),
                    {},
                    { placement: "right", trigger: "click", content: "", template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>' }
                ),
                Li = ki(ki({}, yi.DefaultType), {}, { content: "(string|element|function)" }),
                Ri = "fade",
                Hi = "show",
                xi = ".popover-header",
                Fi = ".popover-body",
                Ui = {
                    HIDE: "hide".concat(Ai),
                    HIDDEN: "hidden".concat(Ai),
                    SHOW: "show".concat(Ai),
                    SHOWN: "shown".concat(Ai),
                    INSERTED: "inserted".concat(Ai),
                    CLICK: "click".concat(Ai),
                    FOCUSIN: "focusin".concat(Ai),
                    FOCUSOUT: "focusout".concat(Ai),
                    MOUSEENTER: "mouseenter".concat(Ai),
                    MOUSELEAVE: "mouseleave".concat(Ai),
                },
                Mi = (function (e) {
                    !(function (e, t) {
                        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
                        (e.prototype = Object.create(t && t.prototype, { constructor: { value: e, writable: !0, configurable: !0 } })), t && Si(e, t);
                    })(a, e);
                    var t,
                        n,
                        i,
                        r = Ci(a);
                    function a() {
                        return Ei(this, a), r.apply(this, arguments);
                    }
                    return (
                        (t = a),
                            (i = [
                                {
                                    key: "_jQueryInterface",
                                    value: function (e) {
                                        return this.each(function () {
                                            var t = o()(this).data("bs.popover"),
                                                n = "object" === bi(e) ? e : null;
                                            if ((t || !/dispose|hide/.test(e)) && (t || ((t = new a(this, n)), o()(this).data("bs.popover", t)), "string" == typeof e)) {
                                                if (void 0 === t[e]) throw new TypeError('No method named "'.concat(e, '"'));
                                                t[e]();
                                            }
                                        });
                                    },
                                },
                                {
                                    key: "VERSION",
                                    get: function () {
                                        return "4.4.1";
                                    },
                                },
                                {
                                    key: "Default",
                                    get: function () {
                                        return Ni;
                                    },
                                },
                                {
                                    key: "NAME",
                                    get: function () {
                                        return "popover";
                                    },
                                },
                                {
                                    key: "DATA_KEY",
                                    get: function () {
                                        return "bs.popover";
                                    },
                                },
                                {
                                    key: "Event",
                                    get: function () {
                                        return Ui;
                                    },
                                },
                                {
                                    key: "EVENT_KEY",
                                    get: function () {
                                        return Ai;
                                    },
                                },
                                {
                                    key: "DefaultType",
                                    get: function () {
                                        return Li;
                                    },
                                },
                            ]),
                        (n = [
                            {
                                key: "isWithContent",
                                value: function () {
                                    return this.getTitle() || this._getContent();
                                },
                            },
                            {
                                key: "addAttachmentClass",
                                value: function (e) {
                                    o()(this.getTipElement()).addClass("".concat("bs-popover", "-").concat(e));
                                },
                            },
                            {
                                key: "getTipElement",
                                value: function () {
                                    return (this.tip = this.tip || o()(this.config.template)[0]), this.tip;
                                },
                            },
                            {
                                key: "setContent",
                                value: function () {
                                    var e = o()(this.getTipElement());
                                    this.setElementContent(e.find(xi), this.getTitle());
                                    var t = this._getContent();
                                    "function" == typeof t && (t = t.call(this.element)), this.setElementContent(e.find(Fi), t), e.removeClass("".concat(Ri, " ").concat(Hi));
                                },
                            },
                            {
                                key: "_getContent",
                                value: function () {
                                    return this.element.getAttribute("data-content") || this.config.content;
                                },
                            },
                            {
                                key: "_cleanTipClass",
                                value: function () {
                                    var e = o()(this.getTipElement()),
                                        t = e.attr("class").match(Pi);
                                    null !== t && t.length > 0 && e.removeClass(t.join(""));
                                },
                            },
                        ]) && wi(t.prototype, n),
                        i && wi(t, i),
                            a
                    );
                })(yi);
            (o.a.fn.popover = Mi._jQueryInterface),
                (o.a.fn.popover.Constructor = Mi),
                (o.a.fn.popover.noConflict = function () {
                    return (o.a.fn.popover = ji), Mi._jQueryInterface;
                });
            var Wi = Mi,
                qi = yi.prototype.setContent;
            yi.prototype.setContent = function () {
                var e = this.element.getAttribute("data-state");
                e && $(this.getTipElement()).addClass("tooltip-".concat(e.replace(/[^a-z0-9_-]/gi, ""))), qi.call(this);
            };
            var Ki = Wi.prototype.setContent;
            Wi.prototype.setContent = function () {
                var e = this.element.getAttribute("data-state");
                e && $(this.getTipElement()).addClass("popover-".concat(e.replace(/[^a-z0-9_-]/gi, ""))), Ki.call(this);
            };
        },
    })
);
