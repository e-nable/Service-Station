e-NABLE Web Generator
=====================

Web Frontend for openscad generation of models given arm measurements

NOTE Currently in alpha development. Minimal security is implimented currently.

This tool leverages the Assembly.scad found at https://github.com/laird/e-NABLE to make an easy to use interface for generating 3d models.

More information can be found at http://enablingthefuture.org 


TODO
======================
- [x] Arm size logging - maybe to a Gdocs spreadsheet form?
- [x] Short URL mapping of full request string for easy sharing
- [x] Remote file uploads to services that want the .stl files
- [x] Email of rendered link after rendering
- [x] Create 'local render' module 

Installation
========
Install this package on a PHP server. Also install the e-Nable Assembler package along with OpenScad from openscad.org.

PHP needs to be able to write to the imagecache folder for storing images.
   chmod 777 imagecache
