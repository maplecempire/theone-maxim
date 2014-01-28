    class FlashDenPreviewFileProtection
    {
        function FlashDenPreviewFileProtection () {
        }
        static function isStolenSWF() {
            if (IsPreviewFile === false) {
                return(false);
            }
            var _local2 = new LocalConnection().domain();
            var _local3 = new mx.utils.CollectionImpl();
            _local3.addItem("flashden");
            _local3.addItem("envato");
            _local3.addItem("localhost");
            _local3.addItem("127.0.0.1");
            var _local1 = mx.utils.IteratorImpl(_local3.getIterator());
            while (_local1.hasNext()) {
                if (_local2.toLowerCase().indexOf(_local1.next().toString().toLowerCase(), 0) > -1) {
                    return(false);
                }
            }
            return(true);
        }
        static var IsPreviewFile = false;
    }