(function() {
  var h = {};
  h = function() {
    var t = 2,
      n = [];
    onmessage = function(e) {
      "exportWAV" === e.data[0]
        ? (function(e) {
            for (
              var s = e.length, a = new Uint8Array(s * t), i = 0;
              i < s;
              i++
            ) {
              var r = i * t,
                U = e[i];
              U > 1 ? (U = 1) : U < -1 && (U = -1),
                (U *= 32768),
                (a[r] = U),
                (a[r + 1] = U >> 8);
            }
            n.push(a);
          })(e.data[1])
        : "getBuffer" === e.data[0] &&
          (function(e) {
            var s = n.length ? n[0].length : 0,
              a = n.length * s,
              i = new Uint8Array(44 + a),
              r = new DataView(i.buffer);
            r.setUint32(0, 1380533830, !1),
              r.setUint32(4, 36 + a, !0),
              r.setUint32(8, 1463899717, !1),
              r.setUint32(12, 1718449184, !1),
              r.setUint32(16, 16, !0),
              r.setUint16(20, 1, !0),
              r.setUint16(22, 1, !0),
              r.setUint32(24, e, !0),
              r.setUint32(28, e * t, !0),
              r.setUint16(32, t, !0),
              r.setUint16(34, 8 * t, !0),
              r.setUint32(36, 1684108385, !1),
              r.setUint32(40, a, !0);
            for (var U = 0; U < n.length; U++) i.set(n[U], U * s + 44);
            (n = []), postMessage(i.buffer, [i.buffer]);
          })(e.data[1]);
    };
  };
  var j = {};
  function k(e, t) {
    if (!(e instanceof t))
      throw new TypeError("Cannot call a class as a function");
  }
  function f(e, t) {
    for (var r = 0; r < t.length; r++) {
      var a = t[r];
      (a.enumerable = a.enumerable || !1),
        (a.configurable = !0),
        "value" in a && (a.writable = !0),
        Object.defineProperty(e, a.key, a);
    }
  }
  function l(e, t, r) {
    return t && f(e.prototype, t), r && f(e, r), e;
  }
  var b,
    g = window.AudioContext || window.webkitAudioContext,
    m = function(e) {
      var t = e
          .toString()
          .replace(/^(\(\)\s*=>|function\s*\(\))\s*{/, "")
          .replace(/}$/, ""),
        r = new Blob([t]);
      return new Worker(URL.createObjectURL(r));
    },
    d = function(e) {
      var t = new Event("error");
      return (t.data = new Error("Wrong state for " + e)), t;
    },
    c = (function() {
      function e(t) {
        var r =
          arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null;
        k(this, e),
          (this.stream = t),
          (this.config = r),
          (this.state = "inactive"),
          (this.em = document.createDocumentFragment()),
          (this.encoder = m(e.encoder));
        var a = this;
        this.encoder.addEventListener("message", function(e) {
          var t = new Event("audio");
          (t.data = new Blob([e.data], {
            type: a.mimeType
          })),
            a.em.dispatchEvent(t),
            "inactive" === a.state && a.em.dispatchEvent(new Event("stop"));
        });
      }
      return (
        l(e, [
          {
            key: "start",
            value: function(e) {
              var t = this;
              if ("inactive" !== this.state)
                return this.em.dispatchEvent(d("start"));
              (this.state = "recording"),
                b || (b = new g(this.config)),
                (this.clone = this.stream.clone()),
                (this.input = b.createMediaStreamSource(this.clone)),
                (this.processor = b.createScriptProcessor(2048, 1, 1)),
                this.encoder.postMessage(["init", b.sampleRate]),
                (this.processor.onaudioprocess = function(e) {
                  "recording" === t.state &&
                    t.encoder.postMessage([
                      "exportWAV",
                      e.inputBuffer.getChannelData(0)
                    ]);
                }),
                this.input.connect(this.processor),
                this.processor.connect(b.destination),
                this.em.dispatchEvent(new Event("start")),
                e &&
                  (this.slicing = setInterval(function() {
                    "recording" === t.state && t.requestData();
                  }, e));
            }
          },
          {
            key: "stop",
            value: function() {
              return "inactive" === this.state
                ? this.em.dispatchEvent(d("stop"))
                : (this.requestData(),
                  (this.state = "inactive"),
                  this.clone.getTracks().forEach(function(e) {
                    e.stop();
                  }),
                  this.processor.disconnect(),
                  this.input.disconnect(),
                  clearInterval(this.slicing));
            }
          },
          {
            key: "pause",
            value: function() {
              return "recording" !== this.state
                ? this.em.dispatchEvent(d("pause"))
                : ((this.state = "paused"),
                  this.em.dispatchEvent(new Event("pause")));
            }
          },
          {
            key: "resume",
            value: function() {
              return "paused" !== this.state
                ? this.em.dispatchEvent(d("resume"))
                : ((this.state = "recording"),
                  this.em.dispatchEvent(new Event("resume")));
            }
          },
          {
            key: "requestData",
            value: function() {
              return "inactive" === this.state
                ? this.em.dispatchEvent(d("requestData"))
                : this.encoder.postMessage(["getBuffer", b.sampleRate]);
            }
          },
          {
            key: "addEventListener",
            value: function() {
              var e;
              (e = this.em).addEventListener.apply(e, arguments);
            }
          },
          {
            key: "removeEventListener",
            value: function() {
              var e;
              (e = this.em).removeEventListener.apply(e, arguments);
            }
          },
          {
            key: "dispatchEvent",
            value: function() {
              var e;
              (e = this.em).dispatchEvent.apply(e, arguments);
            }
          }
        ]),
        e
      );
    })();
  (c.prototype.mimeType = "audio/wav"),
    (c.isTypeSupported = function(e) {
      return c.prototype.mimeType === e;
    }),
    (c.notSupported = !navigator.mediaDevices || !g),
    (c.encoder = h),
    (j = c);
  window.MediaRecorder = j;
})();
