DESCRIPTION
-----------

Conference List is a web application for community-maintained
public lists (e.g. math conferences).  Its basic functions are:

* A web form for adding new announcements, storing them in a database.
* An interface for viewing announcements, sorted by date or location.
* Interfaces to update and delete announcements.

The application is based on the [Cake PHP framework](https://cakephp.org/) (version 5.x).

LICENSE
-------

This program, Conference List, is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.


CHANGELOG
---------

### v. 3.0 (September 2024) ###

Rewritten for the latest versions of PHP (version 8) and CakePHP (version 5).
Functionally is generally the same, with a few improvements.

- There is a search form for searching and filtering results by date of meeting, date of announcement, and other fields.

- When adding an announcement, the Country selector now accepts any alternate spellings such as USA, UK, Deutschland, etc.  The full list is from the [countries data repository](https://github.com/mledoze/countries).

- Announcements that have been added or updated in the last 30 days are marked with **[New]**.

- When adding an announcement, the Start/End Date fields are formatted by users' locale and the [date picker is controlled by  their browser](https://www.w3schools.com/TAGS/att_input_type_date.asp).

- RSS feed deprecated.  CakePHP dropped support for RSS in version 5, and we don't think this was used much.  Get in touch if it impacts you!

- New repository location at
https://github.com/sethjohnson1/conflist5

### v. 2.2 (August 2023) ###

* New location option: 'Online'
* New database fields 'created' and 'modified'

### v. 2.1.5 (July 2019) ###

* Enable configuration for sending email through external servers

### v. 2.1.4 ###

* Rudimentary login for curators

### v. 2.1.3 ###

* ICS feed
* Rudimentary search

### v. 2.1.2 ###

* SSL support
* Google reCaptcha

### v. 2.1.1 ###

* support json and xml views

### v. 2.1 ###

* Now filter announcements by subject tags

* Set specific admin email addresses for individual tags

* Form for editing announcements is now the same as that for adding
  new announcements

* New 'view' page for each announcement, and announcement data in
  confirmation emails

* Select boxes improved with select2 (jquery)

* Links to sort by country or show past announcements have been
  removed as these features are rarely used and are incompatible with
  the subject tags.  If you would like to see these features
  reimplemented, please let Niles know!





ADMINISTRATION
--------------

Site administrators receive a copy of every confirmation email.  If
this is lost or the edit keys there are invalid for some reason, you
can get the edit/delete url for conference number `N` as follows:
Navigate to `conferences/admin/N` and use the admin key from your
private config file.  You can also use conference-specific edit key
there.


HISTORY
-------

This project began as `cakephp-conference-list` available at
  * https://bitbucket.org/nilesjohnson/cakephp-conference-list/
  * https://code.google.com/archive/p/cakephp-conference-list/

Between 2014 and 2024 the project continued as `conference-list` at https://github.com/nilesjohnson/conference-list

In mid 2024 the project was completely rewritten as `conflist5` at
https://github.com/sethjohnson1/conflist5
