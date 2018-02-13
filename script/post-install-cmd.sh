#!/bin/bash

# Special preparations for caching.
cp public/wp-content/plugins/clinical-memcachier/object-cache-memcachier.txt public/wp-content/object-cache.php
cp public/wp-content/plugins/batcache/advanced-cache.php public/wp-content

# Cleanup dirs
# rm -rf tmp/public.building tmp/public.old
# mkdir -p tmp/public.building
rm -rf temp/public
mkdir -p temp/public

# Recursively copy files build final web dir
# cp -R vendor/WordPress/WordPress/* tmp/public.building
# cp -R public/* tmp/public.building
cp -R wordpress/* temp/public
cp -R public/* temp/public

# Move built web dir into place
# mkdir -p public.built
# mv public.built tmp/public.old && mv tmp/public.building public.built
# rm -rf tmp/public.old
mkdir -p www
mv www temp/www && mv temp/public www
rm -rf temp
