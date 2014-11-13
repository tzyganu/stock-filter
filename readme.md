Easylife Stock Filter
==============

Version 
-------

0.1.0-beta  
Even if this is in beta it seams to do what is intended to do. I just need to do more tests before marking it as stable.

Compatibility
-----------

The extension was tested on Magento CE 1.7, 1.8 and 1.9.  
Most probably it works on other versions also.  

What it does
----------

The extension adds a new filter in the layered navigation with 2 options: In stock and out of stock. This way the user can filter only in stock products.
The extension can be used only if your store displays out of stock products. It makes no sense otherwise.  

![Frontend](http://i.imgur.com/XqH9npa.png)

Configuration.
----------

You can configure the extension from System->Configuration->Layered Nav Stock Filter.  
You can change the following fields.



  - **Enabled** - This enables or disables the extension. There is a comment under the field that notifies you if your store is set to show out of stock products or not. See images below.  
  ![Config](http://i.imgur.com/Hs5Jzrl.png)
  ![Config](http://i.imgur.com/u327a5O.png)
  - **Enabled for Catalog pages** - This enables/disables the stock filter for category pages.
  - **Enabled for Search pages** - This enables/disables the stock filter for quick search and advanced search results.
  - **URL param name** - When filtering by stock status or any other filter a new parameter is added to the url. In this case `in-stock=1|0`. From here you can change that parameter
  s name in case `in-stock` is conflicting with an other attribute.
  - **Filter label** - You can change from here, and translate the label of the filter.
  
Rewrites
----------
This extension rewrites 2 blocks `Mage_Catalog_Block_Layer_View` and `Mage_CatalogSearch_Block_Layer` because magento does not offer any valid events to inject additinoal filters.  
Or maybe I missed them. If someone spots one, please spread the word.  
The blocks that override the ones mentioned above, don't do much. They just call the parent methods and dispatch an event that is observed by the same extension.  
This should make it easier to fix conflicts.  

Conflicts
---------
Since this extension rewrites 2 blocks, there is a high chance that it will conflict with other extensions that affect the layered navigation. And there are a lot of them out there.  
To solve such a conflict, you need to edit the blocks `Easylife_StockFilter_Block_Catalog_Layer_View` and `Easylife_StockFilter_Block_Catalogsearch_Layer` and make them extend the blocks from the conflicting extension.  
Then edit `app/etc/modules/Easylife_StockFilter.xml` and add the name of the conflicting extension inside the `<depends>` tag.   
This way, the Stock filter extension is loaded after the other extension that changes the layered navigation, the methods rewritten in the extension blocks do the same thing as their parent blocks to and still dispatch the events needed for the additional filter.  

License
--------
This module is released under the [MIT License (MIT)](http://opensource.org/licenses/MIT)

Issues and feature requests
-----------

Please submit all the issues and feature requests [in here](https://github.com/tzyganu/stock-filter/issues).

