from django.db import models
from people.models import People
# Create your models here.
class Building(models.Model):
    id = models.IntegerField(primary_key=True)
    name = models.CharField(max_length = 50, null = False, blank = False)

    def __str__(self):
        return self.name

class EntryExit(models.Model):
    entryno = models.AutoField(primary_key=True )
    id_name = models.CharField(max_length= 8)
    entrytimestamp = models.DateTimeField(default = None, null = True)
    exittimestamp = models.DateTimeField(default = None, null = True)
    building_id = models.CharField(max_length = 50)

    def __str__(self):
        return self.id_name