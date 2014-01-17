    class mx.utils.IteratorImpl implements mx.utils.Iterator
    {
        var _collection, _cursor;
        function IteratorImpl (_arg2) {
            _collection = _arg2;
            _cursor = 0;
        }
        function hasNext() {
            return(_cursor < _collection.getLength());
        }
        function next() {
            return(_collection.getItemAt(_cursor++));
        }
    }
