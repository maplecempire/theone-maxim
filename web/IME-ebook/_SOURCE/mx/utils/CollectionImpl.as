    class mx.utils.CollectionImpl extends Object implements mx.utils.Collection
    {
        var _items;
        function CollectionImpl () {
            super();
            _items = new Array();
        }
        function addItem(_arg3) {
            var _local2 = false;
            if (_arg3 != null) {
                _items.push(_arg3);
                _local2 = true;
            }
            return(_local2);
        }
        function clear() {
            _items = new Array();
        }
        function contains(_arg2) {
            return(internalGetItem(_arg2) > -1);
        }
        function getItemAt(_arg2) {
            return(_items[_arg2]);
        }
        function getIterator() {
            return(new mx.utils.IteratorImpl(this));
        }
        function getLength() {
            return(_items.length);
        }
        function isEmpty() {
            return(_items.length == 0);
        }
        function removeItem(_arg4) {
            var _local2 = false;
            var _local3 = internalGetItem(_arg4);
            if (_local3 > -1) {
                _items.splice(_local3, 1);
                _local2 = true;
            }
            return(_local2);
        }
        function internalGetItem(_arg4) {
            var _local3 = -1;
            var _local2 = 0;
            while (_local2 < _items.length) {
                if (_items[_local2] == _arg4) {
                    _local3 = _local2;
                    break;
                }
                _local2++;
            }
            return(_local3);
        }
    }
