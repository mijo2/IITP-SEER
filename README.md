# IITP-SEER
IIT Patna's Student Entry Exit Register


## SEER 

  Stands for Secure Entry Exit Register. 

## Division of the project

The project consists of two parts: 
  * The android app 
  * Website which displays the digital portal.

## Entry Exit Register Database
The database name is EntryExit. The database consists of: 
  1. Register, which contains all the entries and exits 
  2. People, which has the details of every person with their roll number or equivalent as primary key 
  3. Admin, which has adminID and password as attributes where adminID is primary key 
  4. Building, which has the buildingID and building name as attributes.

## Working of the application

First, if an unauthorized person will try to access any link in the server, there will be a redirect to the loginportal
if the user isn't logged in already. Once, a user logs in as one of the admins, he will be granted access to the full website. 

Now, the home page of the website consists of a header which has links to Home, Buildings, People and Sign-up portal. 
The home page displays entries of the register in reverse order sorted in descending order of when they were updated 
last and they are grouped by date. There is a search bar in which if you search for any name or roll number, it will
show you results accordingly and related to the field.

If you select any of the Buildings from the header, then the website will function as it did in Home page except it 
will now show entries of only that particular building. The search bar, the header, and the way entries are displayed 
will be of the same nature as earlier.

If you navigate to People page, there will be a form in which if you type and enter a valid ID, then it will show the
details of that ID from People table along with an image of that person. 

If you go to Sign-up portal, then there will be forms to be filled for registering a new person to the database.
Once you fill in correct details and upload a jpg format image, the page will be redirected to Home page but an 
email will be sent to the new person with a qr code which will be used by the app to register an entry or exit for
that person. 

Now coming to app, the first part of the app is the qr code scanner which will scan the QR code and then if the qr code
is valid, it will show details of that person with an image and in the bottom will be two options for the guard, to make
an entry or make an exit. If he/she chooses an entry and if that person is entering that building for the first time,
then a new entry will be made to the register for that building with exit time as null. If the person has already exited
the building and is now making an entry given the register entry in which there is an exit has an entry time as null, then
there will be no new insertion in the register but rather, the entry time will be set to the current timestamp. 
Complement this procedure and you will get how the exit method works.

All the new entries or updates to the register will be updated to the database and consequently the website 
provided there is no database connection error.

