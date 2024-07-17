package com.example.demo.controller;

import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestParam;

@Controller
public class LoginController {

    @PostMapping("/login")
    public String login(@RequestParam("uname") String username, @RequestParam("upassword") String password) {
        // Implement your authentication logic here
        // For demonstration purposes, let's check if the username is "admin" and password is "password"
        if (username.equals("admin") && password.equals("password")) {
            return "redirect:/userdashboard.html"; // Redirect to the dashboard if login is successful
        } else {
            return "redirect:/loginexam.html?error"; // Redirect back to the login page with an error parameter
        }
    }
}