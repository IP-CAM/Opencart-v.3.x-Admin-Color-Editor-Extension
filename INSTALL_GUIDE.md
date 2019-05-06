Installation Guide for Color Editor Extension
====
- The latest version of the extension can be found at [here](https://github.com/facebookincubator/Facebook-For-OpenCart/releases/latest)

====
# Pre-requisites prior to installing the plugin
  1. The plugin supports these OpenCart versions - 3.0.3.2, 3.0.3.1, 3.0.3.0, 3.1.0.0_b, 3.0.2.0, 3.0.1.3, 3.0.1.2, 3.0.1.1, 3.0.1.0, 3.0.0.0.

  2. Installation of the plugin is via OCMOD.
    - For Opencart 3.x, there is no additional setup required to use OCMOD.

    - VQMOD installation is NOT supported.

  3. For Opencart 3.x, you need to disable the theme cache, as we are making modifications to the header.twig file.
    - Go to the admin panel of OpenCart and click on Menu -> Dashboard.
    - Click on the Settings button on the top right.
    - Click on Off option for Theme and click on the Refresh button.

  4. Download the latest version of the extension, oc_color_editor_extension.ocmod.zip.
    - You can get the latest version of the plugin from these websites:
      - [OpenCart marketplace](https://www.opencart.com/index.php?route=marketplace/extension/info&extension_id=36729)
      - [Github latest release](https://github.com/angelfcm/oc_color_editor_extension/releases/latest)

    - Ensure that the extension file ends with .ocmod.zip extension.

  5. Ensure that the OpenCart database user has the permission rights to CREATE_TABLE, ALTER_TABLE, SELECT, UPDATE and DELETE. Our plugin requires these permissions to create a new database table to link the association of choosen colors and store the settings of the Color Editor.

# Plugin installation
  1. Install the Facebook for OpenCart plugin via OCMOD.
    - Go to the admin panel of OpenCart and click on:
      - Menu -> Extensions -> Installer. (For OpenCart v3.x)
    - Click on the Upload button and select the plugin file. Click on the Continue button if required.
    - Go to the admin panel of OpenCart and click on Menu -> Extensions -> Modifications.
    - Click on the Refresh button.

  2. For OpenCart 3.x, you need to perform an additional installation step.

    - Go to the admin panel of OpenCart and click on Menu -> Extensions -> Extensions.
    - Click on the Extension type dropdown list and select Modules.
    - Scroll down the list to locate Facebook Ads Extension and click on Install button.

# Setup for Color Editor
  1. Go to the admin panel of OpenCart and click on Menu -> Design -> Color Editor.

  2. Choose desirable colors and click on save button.

  3. Check changes on catalog page, if you do not see the changes then reload the page until you be able to see them.

# Uninstall the plugin
  1. You must have already installed the Color Editor plugin on your OpenCart server.
  
  2. Go to the admin panel of OpenCart and click on Menu -> Extensions -> Modifications.
  
  3. Locate and select the Color Editor plugin. Click on the Delete button on the top right of the screen. 
  
  4. Click on Ok button to delete the plugin.
  
  5. Click on Refresh button to refresh the existing plugins on your OpenCart server.

# Upgrade the plugin to a later version
  1. You must have already installed the Color Editor plugin on your OpenCart server.
  
  2. Delete the existing Facebook for OpenCart plugin.

  3. Install the later version plugin. Verify that the Facebook for OpenCart version is shown as the later version.