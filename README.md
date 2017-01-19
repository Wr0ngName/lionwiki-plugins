# lionwiki-plugins
A bunch of plugins made for LionWiki (http://lionwiki.0o.cz)

# Installation
Simply copy the file for the related plugin into your lionwiki directory, under the 'plugins' folder. Done!

---
# Anchor

A simple plugin to add an anchor in a page. Useful? Maybe.
> **Syntax: `{anchor:your_anchor_name}`**

# ReCaptcha

A plugin to add Google TReCaptcha support. Help against spammers in comment or admin areas! Replaces the standard text CAPTCHA with the ReCaptcha one. Use the following syntax in your templates.
> **Syntax: `{  plugin:RECAPTCHA}`**

As an example, for the Comments section, you need to:
  1. Add the corresponding plugin source in your /plugins folder.
  2. Configure: your ReCaptcha API ID and the Secret Key;
  3. Replace in the **/plugins/wkp_Comments.php** file, the following line (:197):
  
     ```if(isset($plugins["Captcha"]) && $plugins["Captcha"]->checkCaptcha() == true) {```
     
     with this one:
     
     ```if(isset($plugins["ReCaptcha"]) && $plugins["ReCaptcha"]->checkCaptcha() == true) {```
     
  4. Finally, replace in the **/plugins/Comments/template.html** the line:
  
     ```{  plugin:CAPTCHA}``` with, instead: ```{  plugin:RECAPTCHA}```
     
  5. Profit!


# Youtube

A plugin to add a Youtube video in a page. Without giving the right to write random HTML to the users.
> **Syntax: `{youtube:youtube_video_id}`**

---

# Remarks
Let me know for any security issue, or any other trouble that can happen.

# Regarding LionWiki
Find more about LionWiki at: http://lionwiki.0o.cz/
