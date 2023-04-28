<?php

return [
    "validEmail" => "Please enter a valid email address.",
    "uppercasePassword" => "Password must contains at least one Uppercase.",
    "lowercasePassword" => "Password must contains at least one Lowercase.",
    "digitPassword" => "Password must contans at least one Digit.",
    "specialcharacterPassword" => "Password must contans at least one Special Character",
    'footerEmailTeam' => config('const.APP_NAME') .  'Team',
    'footer' => config('const.APP_NAME') . '| All rights reserved',

    /* User Module */
    'userscreatesuccess' => "User has been created successfully.",
    'usersupdatesuccess' => "User has been updated successfully.",
    'AlreadyAccountVerified'=> 'Your Account Already Verified.',
    'emailverified'=>"Your account has been successfully verified.",
    'emailverifyfail' => "Email varifiaction fail.",
    "strongPassword" => "Your password must contains one Uppercase, Lowercase, Digit and Special Character.",
    'emailExists' => "Email already exists.",
    'profileUpdate'=> 'Profile has been Updated successfully.',
    'profileImageSize' => "The profile Image must be less than 2 MB.",
    'currentPasdswordNotmatch'=>"Your old password does not matches with password you provided. Please try again.",
    
    /*Cms Module */
    'cmscreatesuccess' => "CMS has been created successfully.",
    'cmsupdatesuccess' => 'CMS has been updated successfully.',

    /*Faq Module */
    'faqcreatesuccess' => "FAQ has been created successfully.",
    'faqupdatesuccess' => 'FAQ has been updated successfully.',
    
    
    'AlreadyAccountVerified' => 'Your Account Already Verified.',
    'emailverified' => "Your account has been successfully verified.",
    'emailverifyfail' => "Email varifiaction fail.",

    /* Role Module */
    'rolecreatesuccess' => "Role has been created successfully.",
    'roleupdatesuccess' => "Role has been updated successfully.",

    "notAuthorizedAdmin" => "You are not authorized user to access this account.",
    "accountInactive" => "Your account is inactive, Please contact administrator.",

    'AuthenticationFail' => 'Authentication failed, Invalid login details.',
    "oopserror" => "Oops, something went wrong...",
    'error' => "Error !!",
    "recordDelete" => "Record deleted successfully.",
    'success' => "Success !!",

    /* Forgot Password & Reset Password */
    "notfoundEmail" => "We do not have an active account with that email address.",
    'forgotPassword' => "We have sent a link to your registered email address.  Please review the email and follow the instruction to reset your password.",
    "passwordResetSuccess" => "Your password has been reseted successfully",
    
    "InvalidResetPassword" => "Your reset password link may be expired OR Invalid token, Please try again using forgot password.",
    "passwordChangeSucess" => "Your Password has been changed successfully.",
    "clearNotification" => "Notification has been cleared successfully.",
    "supportUpdateSuccess" => "Support request has been updated successfully.",
    "attachmentDeleteSuccess" => "Attachment has been deleted successfully.",
];