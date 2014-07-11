e-NABLE Handomatic Web Interface
=====================

Web Frontend for openscad generation of models given arm measurements.

This tool leverages the Assembly.scad found at https://github.com/e-nable/e-NABLE-Assembler to make an easy to use interface for generating 3d hand models.

NOTE: Currently in alpha development. Minimal security is currently implimented.

More information regarding e-NABLE can be found at http://enablingthefuture.org 

Installation
========
Requires a Linux LAMP stack - at minimum:

- [x] linux x64
- [x] html server
- [x] php engine
- [x] openSCAD 2014.03 (prefer 2014.05.31 and above)

This will run in a headless server through: Xvfb.

Ubuntu install guide provided under project as installNotes.txt.

Service-Station acts as the root or base directory for the web directory being served up. The provided PHP scripts assume e-NABLE-Assembler project is linked as [web-directory]/e-NABLE. Check installer notes for more details.

Resources
========
OpenScad Development Snaphots (do a hand install): http://www.openscad.org/downloads.html

To retrieve current dev snapshot (July 10, 2014): wget http://files.openscad.org/snapshots/openscad-2014.05.31.x86-64.tar.gz
