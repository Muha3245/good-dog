<style>
   .gooddog-footer {
            background-color: #6b2514;
            color: #ecf0f1;
            padding: 40px 0 20px;
            font-family: 'Open Sans', sans-serif;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-col {
            margin-bottom: 20px;
        }

        .footer-heading {
            color: #fff;
            font-size: 18px;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background: #e74c3c;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #e74c3c;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            color: #fff;
            background: #34495e;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background: #e74c3c;
            transform: translateY(-3px);
        }

        .newsletter-form {
            display: flex;
            margin-top: 15px;
        }

        .newsletter-form input {
            padding: 10px;
            border: none;
            border-radius: 4px 0 0 4px;
            flex: 1;
        }

        .newsletter-form button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 0 15px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background 0.3s;
        }

        .newsletter-form button:hover {
            background: #c0392b;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid #34495e;
            font-size: 14px;
        }

        .payment-methods img {
            height: 25px;
            margin-left: 15px;
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
        }
</style>

<!-- Footer Section -->
<footer class="gooddog-footer">
    <div class="footer-container">
      <!-- Main Footer Content -->
      <div class="footer-grid">
        <!-- Company Info -->
        <div class="footer-col">
          <a href="/"><img src="{{ asset('logo.jpeg')}}" alt=""
          style="width: auto; height: 100px; object-fit: cover; border-radius: 50%; padding:10px;"></a>
          
          <h3 class="footer-heading">Good Dog</h3>
          <p class="footer-text">Helping you find the perfect dog since 2010.</p>
          <div class="social-links">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-pinterest-p"></i></a>
          </div>
        </div>
  
        <!-- Quick Links -->
        <div class="footer-col">
          <h3 class="footer-heading">Quick Links</h3>
          <ul class="footer-links">
            <li><a href="/about">About Us</a></li>
            <li><a href="/#">Find a Breeder</a></li>
            <li><a href="/#">Browse Dogs</a></li>
            <li><a href="/#">Resources</a></li>
          </ul>
        </div>
  
        <!-- Help & Support -->
        <div class="footer-col">
          <h3 class="footer-heading">Help</h3>
          <ul class="footer-links">
            <li><a href="/contact">Contact Us</a></li>
            <li><a href="/#">FAQ</a></li>
            <li><a href="/#">Privacy Policy</a></li>
            <li><a href="/#">Terms of Service</a></li>
          </ul>
        </div>
  
        <!-- Newsletter -->
        <div class="footer-col">
          <h3 class="footer-heading">Newsletter</h3>
          <p class="footer-text">Subscribe for dog care tips and updates</p>
          <form class="newsletter-form">
            <input type="email" placeholder="Your email" required>
            <button type="submit">Subscribe</button>
          </form>
        </div>
      </div>
  
      <!-- Copyright -->
      <div class="footer-bottom">
        <p>&copy; 2023 Good Dog. All rights reserved.</p>
        {{-- <div class="payment-methods">
          <img src="/images/visa.png" alt="Visa">
          <img src="/images/mastercard.png" alt="Mastercard">
          <img src="/images/amex.png" alt="American Express">
        </div> --}}
      </div>
    </div>
  </footer>
  
  <!-- CSS Styles -->
  <style>
  .gooddog-footer {
    background-color: #6b2514;
    color: #ecf0f1;
    padding: 40px 0 20px;
    font-family: 'Open Sans', sans-serif;
  }
  
  .footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }
  
  .footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
  }
  
  .footer-col {
    margin-bottom: 20px;
  }
  
  .footer-heading {
    color: #fff;
    font-size: 18px;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
  }
  
  .footer-heading::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 2px;
    background: #e74c3c;
  }
  
  .footer-links {
    list-style: none;
    padding: 0;
  }
  
  .footer-links li {
    margin-bottom: 10px;
  }
  
  .footer-links a {
    color: #bdc3c7;
    text-decoration: none;
    transition: color 0.3s;
  }
  
  .footer-links a:hover {
    color: #e74c3c;
  }
  
  .social-links {
    display: flex;
    gap: 15px;
    margin-top: 20px;
  }
  
  .social-icon {
    color: #fff;
    background: #34495e;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
  }
  
  .social-icon:hover {
    background: #e74c3c;
    transform: translateY(-3px);
  }
  
  .newsletter-form {
    display: flex;
    margin-top: 15px;
  }
  
  .newsletter-form input {
    padding: 10px;
    border: none;
    border-radius: 4px 0 0 4px;
    flex: 1;
  }
  
  .newsletter-form button {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 0 15px;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
    transition: background 0.3s;
  }
  
  .newsletter-form button:hover {
    background: #c0392b;
  }
  
  .footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 1px solid #34495e;
    font-size: 14px;
  }
  
  .payment-methods img {
    height: 25px;
    margin-left: 15px;
  }
  
  @media (max-width: 768px) {
    .footer-grid {
      grid-template-columns: 1fr 1fr;
    }
    
    .footer-bottom {
      flex-direction: column;
      text-align: center;
      gap: 15px;
    }
  }
  </style>
  
  <!-- JavaScript for Newsletter -->
  <script>
  document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.querySelector('input').value;
    alert(`Thanks for subscribing with ${email}!`);
    this.reset();
  });
  </script>