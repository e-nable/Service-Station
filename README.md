e-NABLE Handomatic Web Interface
=====================

Web Frontend for openscad generation of models given arm measurements.

This tool leverages the Assembly.scad found at https://github.com/e-nable/Assembler to make an easy to use interface for generating 3d hand models.
<<<<<<< HEAD
=======

The overall control flow is:

<img src="https://docs.google.com/drawings/d/1fMVuwL2IDA7K7xmZVibVewTpJstXPqoUx9exW6ODkQM/pub?w=960&amp;h=720">

This repository contains the web UI.
>>>>>>> analytics2

NOTE: Currently in alpha development. Minimal security is currently implimented.

More information regarding e-NABLE can be found at http://enablingthefuture.org 

Installation
========
Requires a Linux LAMP stack - at minimum:

- [x] linux x64 - ex. Ubuntu Desktop 64-bit v14+ LTS
- [x] html server
- [x] php engine
- [x] openSCAD 2014.03 (prefer 2014.05.31 and above)

This will run in a headless server through: Xvfb.

Ubuntu install guide provided under installNotes.txt (https://github.com/e-nable/Service-Station/blob/master/installNotes.txt).

Service-Station acts as the root or base directory for the web directory being served up. The provided PHP scripts assume Assembler project is linked as [web-directory]/e-NABLE. Check installer notes for more details.

Resources
========
OpenScad Development Snaphots (do a hand install): http://www.openscad.org/downloads.html

To retrieve current dev snapshot (July 10, 2014): wget http://files.openscad.org/snapshots/openscad-2014.05.31.x86-64.tar.gz
