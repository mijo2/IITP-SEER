
from django.db import models


#This Model defines the table that containes the details of the peopl.
class People(models.Model):
    id = models.CharField(max_length = 8, primary_key = True)
    name = models.CharField(max_length = 50)
    phone = models.CharField(unique = True, max_length = 10)
    photo = models.ImageField(upload_to='student_images')
    email = models.EmailField(default = None)


    def __str__(self):
        return self.id