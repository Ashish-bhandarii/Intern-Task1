document.getElementById("contactForm").addEventListener("submit", function (e) {
    e.preventDefault()
  
    resetErrors()
  
    // Get all form elements
    const username = document.getElementById("username")
    const email = document.getElementById("email")
    const phone = document.getElementById("phone")
    const subject = document.getElementById("subject")
    const message = document.getElementById("message")
  
    let isValid = true
  
    // Username validation
    if (!username.value.trim()) {
      showError(username, "Username is required")
      isValid = false
    } else if (!/^[A-Za-z\s]{2,50}$/.test(username.value.trim())) {
      showError(username, "Username should only contain letters and spaces (2-50 characters)")
      isValid = false
    }
  
    // Email validation
    if (!email.value.trim()) {
      showError(email, "Email is required")
      isValid = false
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
      showError(email, "Please enter a valid email address")
      isValid = false
    }
  
    // Phone validation
    if (!phone.value.trim()) {
      showError(phone, "Phone number is required")
      isValid = false
    } else if (!/^(98|97)\d{8}$/.test(phone.value.trim())) {
      showError(phone, "Phone number must start with 98 or 97 and be 10 digits long")
      isValid = false
    }
  
    // Subject validation
    if (!subject.value.trim()) {
      showError(subject, "Subject is required")
      isValid = false
    } else if (subject.value.trim().length < 3) {
      showError(subject, "Subject must be at least 3 characters long")
      isValid = false
    } else if (subject.value.trim().length > 100) {
      showError(subject, "Subject cannot exceed 100 characters")
      isValid = false
    }
  
    // Message validation
    if (!message.value.trim()) {
      showError(message, "Message is required")
      isValid = false
    } else if (message.value.trim().length < 10) {
      showError(message, "Message must be at least 10 characters long")
      isValid = false
    }
  
   
    if (isValid) {
      const successMessage = document.getElementById("successMessage")
  
      fetch("submit.php", {
        method: "POST",
        body: new FormData(this),
      })
        .then((response) => {
          // Check if the response is valid JSON
          const contentType = response.headers.get("content-type")
          if (contentType && contentType.includes("application/json")) {
            return response.json()
          } else {
            // If not JSON, get as text and try to parse
            return response.text().then((text) => {
              try {
                return JSON.parse(text)
              } catch (e) {
                // If parsing fails, return the text as message
                return { success: true, message: text || "Form submitted successfully" }
              }
            })
          }
        })
        .then((data) => {
          console.log("Server response:", data);
  
        
          if (data && typeof data === "object") {
            // If we got a proper JSON response
            successMessage.textContent = data.message || "Form submitted successfully"
  
          
            if (data.success) {
              successMessage.className = "alert alert-success mt-3"
            } else {
              successMessage.className = "alert alert-danger mt-3"
            }
          } else {
            // Fallback for unexpected response
            successMessage.textContent = "Form submitted successfully"
            successMessage.className = "alert alert-success mt-3"
          }
  
          successMessage.style.display = "block"
  
          
          if (!data || data.success) {
            this.reset()
          }
  
          // Hide success message after 5 seconds
          setTimeout(() => {
            successMessage.style.display = "none"
           
            if (!data || data.success) {
              location.reload()
            }
          }, 5000)
        })
        .catch((error) => {
          console.error("Error:", error) // Debug: Log any errors
          successMessage.textContent = "Error submitting form: " + error
          successMessage.className = "alert alert-danger mt-3"
          successMessage.style.display = "block"
        })
    }
  })
  
  // Function to show error messages
  function showError(input, message) {
    const errorElement = document.getElementById(input.id + "-error")
    errorElement.textContent = message
    input.classList.add("is-invalid")
  }
  
  // Function to reset all error states
  function resetErrors() {
    // Remove all error messages
    const errorElements = document.querySelectorAll(".error")
    errorElements.forEach((element) => {
      element.textContent = ""
    })
  
    // Remove all error borders
    const inputs = document.querySelectorAll("input, textarea")
    inputs.forEach((input) => {
      input.classList.remove("is-invalid")
    })
  }
  
  // Real-time validation
  document.querySelectorAll("input, textarea").forEach((input) => {
    input.addEventListener("input", function () {
      // Clear error when user starts typing
      const errorElement = document.getElementById(this.id + "-error")
      errorElement.textContent = ""
      this.classList.remove("is-invalid")
    })
  })
  
  