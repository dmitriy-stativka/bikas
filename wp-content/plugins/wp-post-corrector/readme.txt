=== WP Post Corrector ===
Contributors: vipuljariwala
Donate link: http://wpwebs.com/
Tags: wp post correct, Post correc,blog correct
Requires at least: 4.8
Tested up to: 4.9
Stable tag: 1.0.2
Requires PHP: 5.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html


"WP Post Corrector" is a plugin, helpful you to correct your post data. 
It contains mainly 3 modules. Bulk Upload (Insert Mass Post Data), Bulk Update (Update Mass Post Data) and Download Complete Data Excel.

== Description ==

"WP Post Corrector" is a plugin, helpful you to correct your post data. 
It contains mainly 3 modules. 
(1)Bulk Upload (Insert Mass Post Data)
(2)Bulk Update (Update Mass Post Data) and
(3)Download Complete Data Excel

(1) Bulk Inset is useful for mass/bulk post data insertion for your site via CSV file. Normally we using "Microsoft CSV" file only. First of all get Create Microsoft Excel file and save it as "CSV(comma seperated format)".  Download sample CSV file to get more help how to prepare the CSV file for Bulk Upload or Mass Upload.

In the sample CSV as you can see some of the rule are common.

-->First column of CSV must be the title of the row.

-->All titles in the row may be changed as per your post custom fields, while post common information like title,content,tags,author,category will be same for any of csv sample data. It should never changed, if you really want to insert your data.
Here ts.
*  post_title : Post Title
*  post_content : Post Content data
*  post_excerpt : Post Excerpt data  
*  category : Post category name. You can insert more then one category name seperated by comma. One of the advantage of this plugin is, it will create new category it self is any of missing so be sure while inserting categor name. It's case sensitive. If the same category name exists, plugin will get the category ID from it's name. <u>If there is more than one category of same name, it's difficulty to decide on which category the post will be inserted. In such case the smartest way is change any of category name so plugin match the category and you have the correct result.</u>
*  post_tag : Post Tags
*  post_author : Post Author name. Insert the user "user_login" or user login ID as for this column. The plugin will find the user ID from user login and will assign author ID to your post.
*  post_status : Post Status. You can set the post status either "publish" or "draft" or "private" or any as you want.
*  comment_status : Post comment status. you can set either "open" or "closed".
-------------------------
*     IMAGE  :Post image or post attachment image column filed. If you want to insert post image (post attachment image), The row title should be "IMAGE". You can insert more than one image by add more and more row with same title.
-------------------------
All above fields are fixed title fields. All are case sensitive. If you change title, it will consider as post custom field and inserted as post custom field.

-------------------------
The custom fields name should same as you can see the field name from custo filed box, while add/edit post from wp-admin.

___________________________________

In the sample CSV file we have consider all type of possibility of the post data that  
Normally used in almost blog.


(2)Bulk Update: same as in Bulk Insert but only update the post data while in the Bulk  
Insert will insert post every time without checking the post title. If there is some  
Mistake in the post data either title, description or any of custom fields, you can use  
This Bulk update module. Get the complete data in the Excel format through "Download  
Complete Data Excel" and do updates or correction as you want -- Save it as "CSV" format  
And upload from Bulk Upload module. You can see the post data will be affected.

3) Download Complete Data Excel: It will give you downloaded the complete post data in  
Excel format. It will give you title, content, category, excerpt, tags, author, status and  
Comment status with all custom filed in the single Microsoft excel format. You can get  
It downloads and do your changes as you want. You can store it as data backup also. Same  
Way you can use it for Report or for Mass Upload or Mass Update. Make sure you should  
Convert it to CSV before using for bulk uploads or bulk update.

This plug-in is supporting only Microsoft excel and csv format. So please install the  
Microsoft office software if you want to use this plug-in otherwise this plug-in doesn’t  
Support other file formats.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `plugin folder` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. See the plugin Actived
4. Once you have installed this plugin, you can see the "WP Correct" link from wp-admin > Tools (left menu) Section.

== Frequently Asked Questions ==


= Why WP Post Corrector ? =

Some times it's necessary to update all blog post data. If there are few posts then it's easy to manage but is there are large number then it's really time consuming task. Also one kind of laber task. In such case using "WP Post Corrector", you can get all the data in a single excel file, update or correct it and re upload in via "Bulk Update". Faster and easiest way.



= Which type of files can upload? =

This plugin supports only Microsoft excel format while get backup and CSV format from Microsoft excel only for Bulk Upload and Bulk Update. No other formats are supported.


= Why CSV format only? =

As in csv our data contains as normal string data not formatted like in excel sheet. As an Example if we are using excel sheet and want to insert date as one of post data, Excel 
Will format the date format to its standard format instead of our post data format so  
It may mismatch of data and case of wrong data format.


= How many posts can be inserted at a time? =


You can insert 800 to 1000 posts at a time. It meanse you can insert that many post with complete data in the csv file and uplod or update at a time.



== Screenshots ==

1. screen 01
2. screen 02

== Changelog ==

= 1.0.2 =
*	correction as per latest wordpress version.

= 1.0.1 =
*	correction as per latest wordpress version.

= 1.0.0 =
*   Fresh Version



== Upgrade Notice ==

= 1.0.2 =
correction as per latest wordpress version.



== Arbitrary section ==

*   This plugin supports only Microsoft excel format while get backup and CSV format from Microsoft excel only for Bulk Upload and Bulk Update. No other formats are supported.

*   You can insert 800 to 1000 posts at a time. It meanse you can insert that many post with complete data in the csv file and uplod or update at a time.


== A brief Markdown Example ==

once you have installed this plugin, you can see the "WP Correct" link from wp-admin > Tools (left menu) > WP Correct. 


