# Fall 2015 Weblab Project: Flora Information Collection System

#Overview
The FICS is an online tool to collect plant information from the field, submit it to a database, and report. 

##Collection
The collection form includes:
* name of submitter (optional)
* a unique id
   * automatically generated, alphanumeric, non sequential to limit conflicts. It can be database or programnatically generated. A guid, perhaps.
* Date & time when data was gathered 
   * This field will default to the current date and time, but be modifiable should data entry not be simultaneous with observation.
* plant name
  * This may include the option to select from a list of existing names to limit duplicate entries.
* soil conditions
  * This is a drop down select list: [sand,silt,clay,leam,peat,gravel,rocky] 
* weather
  * This is a free-form text field which may default to the current weather conditions if we figure out how to do that.
* location
  * lat/lon and/or description. This may be automatically populated with the current location if we figure out how to make that happen.
* additional notes
  * Any comments the submitter wishes to include.

##Data Storage
The data collected is stored in a mySQL relational database.

##Reporting
Reporting is a secured operation, i.e., password protected, with one administrative user. Data is downloadable in csv format.

#Implementation
FICS is implemented with 
* HTML5/CSS
* PHP
* JavaScript
* jQuery
* Bootstrap
	
	
# References
* http://www.geoplugin.com/examples
* http://www.phpclasses.org/package/4472-PHP-Parse-a-XML-document-into-an-array.html
