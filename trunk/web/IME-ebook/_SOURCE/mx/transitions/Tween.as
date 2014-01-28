﻿    class mx.transitions.Tween
    {
        var obj, prop, begin, useSeconds, _listeners, addListener, prevTime, _time, looping, _duration, broadcastMessage, isPlaying, _fps, prevPos, _pos, change, _intervalID, _startTime;
        function Tween (_arg8, _arg5, _arg4, _arg3, _arg6, _arg7, _arg9) {
            mx.transitions.OnEnterFrameBeacon.init();
            if (!arguments.length) {
                return;
            }
            obj = _arg8;
            prop = _arg5;
            begin = _arg3;
            position = (_arg3);
            duration = (_arg7);
            useSeconds = _arg9;
            if (_arg4) {
                func = _arg4;
            }
            finish = (_arg6);
            _listeners = [];
            this.addListener(this);
            this.start();
        }
        function set time(_arg2) {
            prevTime = _time;
            if (_arg2 > duration) {
                if (looping) {
                    rewind(_arg2 - _duration);
                    update();
                    this.broadcastMessage("onMotionLooped", this);
                } else {
                    if (useSeconds) {
                        _time = _duration;
                        update();
                    }
                    this.stop();
                    this.broadcastMessage("onMotionFinished", this);
                }
            } else if (_arg2 < 0) {
                rewind();
                update();
            } else {
                _time = _arg2;
                update();
            }
            //return(time);
        }
        function get time() {
            return(_time);
        }
        function set duration(_arg3) {
            _duration = (((_arg3 == null) || (_arg3 <= 0)) ? (_global.Infinity) : (_arg3));
            //return(duration);
        }
        function get duration() {
            return(_duration);
        }
        function set FPS(_arg3) {
            var _local2 = isPlaying;
            stopEnterFrame();
            _fps = _arg3;
            if (_local2) {
                startEnterFrame();
            }
            //return(FPS);
        }
        function get FPS() {
            return(_fps);
        }
        function set position(_arg2) {
            setPosition(_arg2);
            //return(position);
        }
        function setPosition(_arg2) {
            prevPos = _pos;
            obj[prop] = (_pos = _arg2);
            this.broadcastMessage("onMotionChanged", this, _pos);
            updateAfterEvent();
        }
        function get position() {
            return(getPosition());
        }
        function getPosition(_arg2) {
            if (_arg2 == undefined) {
                _arg2 = _time;
            }
            return(func(_arg2, begin, change, _duration));
        }
        function set finish(_arg2) {
            change = _arg2 - begin;
            //return(finish);
        }
        function get finish() {
            return(begin + change);
        }
        function continueTo(_arg3, _arg2) {
            begin = position;
            finish = (_arg3);
            if (_arg2 != undefined) {
                duration = (_arg2);
            }
            this.start();
        }
        function yoyo() {
            continueTo(begin, time);
        }
        function startEnterFrame() {
            if (_fps == undefined) {
                _global["MovieClip"].addListener(this);
            } else {
                _intervalID = setInterval(this, "onEnterFrame", 1000 / _fps);
            }
            isPlaying = true;
        }
        function stopEnterFrame() {
            if (_fps == undefined) {
                _global["MovieClip"].removeListener(this);
            } else {
                clearInterval(_intervalID);
            }
            isPlaying = false;
        }
        function start() {
            rewind();
            startEnterFrame();
            this.broadcastMessage("onMotionStarted", this);
        }

        function stop() {
            stopEnterFrame();
            this.broadcastMessage("onMotionStopped", this);
        }
        function resume() {
            fixTime();
            startEnterFrame();
            this.broadcastMessage("onMotionResumed", this);
        }
        function rewind(_arg2) {
            _time = ((_arg2 == undefined) ? 0 : (_arg2));
            fixTime();
            update();
        }
        function fforward() {
            time = (_duration);
            fixTime();
        }
        function nextFrame() {
            if (useSeconds) {
                time = ((getTimer() - _startTime) / 1000);
            } else {
                time = (_time + 1);
            }
        }
        function onEnterFrame() {
            this.nextFrame();
        }
        function prevFrame() {
            if (!useSeconds) {
                time = (_time - 1);
            }
        }
        function toString() {
            return("[Tween]");
        }
        function fixTime() {
            if (useSeconds) {
                _startTime = getTimer() - (_time * 1000);
            }
        }
        function update() {
            position = (getPosition(_time));
        }
        static var version = "1.1.0.52";
        static var __initBeacon = mx.transitions.OnEnterFrameBeacon.init();
        static var __initBroadcaster = mx.transitions.BroadcasterMX.initialize(mx.transitions.Tween.prototype, true);
        function func(_arg2, _arg4, _arg3, _arg1) {
            return(((_arg3 * _arg2) / _arg1) + _arg4);
        }
    }
