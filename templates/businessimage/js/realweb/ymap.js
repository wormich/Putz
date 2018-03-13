(function() {
    'use strict';

    var $;

    var __ = {
        each: function(arr, handler){
            for(var i = 0, _len = arr.length; i < _len; i++){
                if(handler.call(arr[i], i, arr[i]) === false) break;
            }
        },
        delay: function(timeout, handler){
            return {
                timerID: setTimeout(handler, timeout),
                stop: function(){
                    clearTimeout(this.timerID)
                }
            }
        },
        async: function(handler){
            this.delay(10, handler);
        }
    }


    var Map = (function(){
        function Map(params, mapParams){
            this.params = params;
            this.$map = $('#' + mapParams.id).empty();
            this.map = new ymaps.Map(mapParams.id, mapParams.options || {}, {});
            this.map.controls
                .add('smallZoomControl')
                .add('scaleLine');
            this.parseAllCity();

            var _this = this;
            this.getAllCityData(function(){
                _this.map.events.add('boundschange', function(){
                    // _this.renderMarkers();
                });
                _this.parseMarkers();
                _this.renderMarkers();
                _this.refreshCurrentMarker();
                _this._ready();
            });
            return this;
        }

        Map.prototype._ready = function(){
            if(this._onReadyList == null) return this;
            __.each(this._onReadyList, function(){
                __.async(this);
            });
            return this;
        }

        Map.prototype.onReady = function(cb){
            if(this._onReadyList == null){
                this._onReadyList = [];
            }
            if(typeof cb == 'function'){
                this._onReadyList.push(cb);
            }
            return this;
        }

        Map.prototype.getAllCityData = (function(){
            var _get = function(list, cb){
                var result = [];
                var left = list.length;
                __.each(list, function(index, city){
                    __.async(function(){
                        $.getJSON(_this.getCityUrl(city), function (data) {
                            left--;
                            list[index].data = data;
                            if(left <= 0){
                                cb(list);
                            }
                        });
                    })
                })
            }
            var _lastData = null;
            var _this;

            return function(cb, useCache){
                _this = this;
                if(_lastData && useCache !== false){
                    cb(_lastData);
                } else {
                    _get(this.cityList, function(data){
                        _lastData = data;
                        cb(_lastData);
                    });
                }
                return this;
            }
        })();

        Map.prototype.parseAllCity = function(){
            this.cityList = [];
            var _this = this;
            var $tmp = $('form.filter').clone();
            var $filter = $tmp.find('#city_filter');
            $filter.find('option').each(function(){
                if($(this).attr('value') == '') return;
                $filter.val( $(this).attr('value') );
                _this.cityList.push({
                    id: $(this).attr('value'),
                    url: $tmp.serialize()
                })
            });
            return this;
        }

        Map.prototype.getCityUrl = function(city){
            // return './' + city.id + '.json';
            var pid = (window.pid) ? window.pid + '/' : '';

            return "/sample_module/allPoints/" + pid + '?' + city.url;
        }

        Map.prototype.parseMarkers = function(){
            var balloonTemplate = ymaps.templateLayoutFactory.createClass(jQuery('#balloonTemplate').html());

            if(this.mapObjects != null){
                this.mapObjects.removeAll();
            }
            var _this = this;
            var _objects = [];

            this.mapObjects = new ymaps.GeoObjectCollection();
            __.each(this.cityList, function(cityIndex, cityObject){
                var points = cityObject.data.list;
                __.each(points, function(i, point){
                    var info = point.info;

                    var nameIcon = '';
                    switch (info.status) {
                        case 'head-office':
                            nameIcon = 'lp-main';
                            break;
                        case 'dealer':
                            nameIcon = 'lp-d';
                            break;
                        case 'partner':
                            nameIcon = 'lp-p';
                            break;
                    }

                    var placemark = new ymaps.Placemark([point.lat, point.lon], {
                        'name': point.name,
                        'address': info.address,
                        'phone': info.phone,
                        'email': info.email,
                        'fax': info.fax,
                        'site': info.site,
                        'itemId': point.id
                    }, {
                        'draggable': false,
                        'iconImageHref':  '/templates/businessimage/images/' + nameIcon + '.png',
                        'iconImageSize': [28, 43],
                        'balloonContentLayout': balloonTemplate
                    });
                    placemark.__parent = cityObject;
                    // _objects.push(placemark);
                    _this.mapObjects.add(placemark);
                });
            });
            return this;
        }

        Map.prototype.renderMarkers = function(){
            this.map.geoObjects.add(this.mapObjects);

        }

        Map.prototype.getCurrentCityObject = function(){
            var currentCityId = $('#city_filter').val();
            if(currentCityId === '') return true;
            var currentObj = null;
            __.each(this.cityList, function(index, cityObject){
                if(cityObject.id == currentCityId){
                    currentObj = cityObject;
                    return false;
                }
            });
            return currentObj;
        }

        Map.prototype.refreshCurrentMarker = function(){
            var _this = this;
            this.currentCity = this.getCurrentCityObject();

            _this.currentPoints = [];

            if(_this.currentCity !== true){
                this.mapObjects.each(function(obj){
                    if(obj.__parent.id == _this.currentCity.id){
                        _this.currentPoints.push(obj);
                    }
                });
            }

             this.mapObjects.each(function(el){
              el.balloon.close();
             });

            var pos = (_this.currentCity === true ? this.mapObjects : (new ymaps.geoQuery(_this.currentPoints))).getBounds();

            this.map.setBounds(pos, {
                zoomMargin: 50,
                checkZoomRange: true,
                callback: function (err) {
                    if (err) {}
                    else {
                        if(_this.currentPoints.length == 1){
                            _this.currentPoints[0].balloon.open();
                        }
                    }
                }
            });
        }


        return Map;
    })();


    var initMap = function(){
        $ = jQuery;
        var contactsMap = new Map({
            markersUrl: "allPoints.json"
        }, {
            id: 'mapsID',
            options: {
                center: [54.982141, 73.38049],
                zoom: 4
            }
        }).onReady(function(){
            $('#city_filter').change(function(){
                __.async(function(){
                    contactsMap.refreshCurrentMarker();
                });
            });
        });
    }

    ymaps.ready(initMap);
})();