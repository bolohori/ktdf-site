#!/bin/sh

# Activate and enable Redis
wp redis enable
wp redis update-dropin

# Activate Interfacelab Media Cloud plugin.
wp plugin activate ilab-media-tools