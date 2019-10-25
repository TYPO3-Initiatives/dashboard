.. include:: ../Includes.txt

.. index:: Installation

.. _installation:

============
Installation
============

Target group: **Administrators**

Installation with composer
==========================

Check whether you are already using the extension with

.. code-block:: bash

   composer show | grep friendsoftypo3/dashboard

This should either give you no result or something similar to:

.. code-block:: bash

   friendsoftypo3/dashboard                                    1.0.0            Dashboard for TYPO3

If it is not yet installed, use the ``composer require`` command to install the extension

.. code-block:: bash

   composer require friendsoftypo3/dashboard

The given version depends on the version of the TYPO3 core you are using.

Now head over to the extension manager and activate the extension.

Installation without composer
=============================

Will not be possible at all, use composer!
