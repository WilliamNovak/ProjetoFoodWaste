# ProjetoFoodWaste
:hamburger: Final project of IT technical course. Application for supermarkets to donate surplus food to charities instituitions, reducing hunger and food waste.

The application works as a way to connect supermarkets that want to donate food in good condition and institutions that need more food to feed their dependents.
- Research and studies have been done on the issues of food insecurity and food waste, as well on Law 14016 that validates the implementation of the project.
- :link: Project's researches and report can ben downloaded here: [Food Waste - Dionatan, Lázaro e William.pdf](https://github.com/WilliamNovak/ProjetoFoodWaste/files/11056961/Food.Waste.-.Dionatan.Lazaro.e.William.pdf)

<h3>Funcionalities:</h3>

<ul>
  <li>Homepage with a small overview about the project.</li>
  <li>Sign In and Sing Up pages.</li>
    - Passwords cryptography is made using password_hash and password_verify from PHP <br>
    - User can sign up as donator or receiver
  <li>Foods page (only for donor)</li>
    - Add, update and delete foods <br>
    - Donate foods <br>
    - If the expiry date expires, the food cannot be donated
  <li>Donations page (only for donor)</li>
  <li>Donation offers page (only for receivers)</li>
    - The user can accept or refuse the donation <br>
    - If refuse, the donation is reallocated to another receiver
  <li>Received donations page (only for receivers)</li>
  <li>Dashboard page</li>
    - Cards with informations about the donations of the year <br>
    - Charts with data and indicators about the donations per month in the last year
  <li>Redirect Donations Algorithm</li>
    - The process of redirecting donations is done by a selection algorithm developed in this project <br>
    - It searches the receiver who had fewer opportunities and needs donations, based on some criteries (explained in download file) <br>
    - The intention of this is to provide equal food conditions for all partner institutions
</ul>
