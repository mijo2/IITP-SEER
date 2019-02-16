from django.contrib.auth.models import User, Group
from rest_framework.serializers import ModelSerializer, CharField, ValidationError, Serializer
from entryexit.models import EntryExit, Building
from people.models import People


class EntryExitSerializer(ModelSerializer):
    class Meta:
        model = EntryExit
        fields = ('id_name',  'entrytimestamp','exittimestamp', 'building_id')
    
    def validate(self, data):
        id_name = data.get('id_name', None)
        building_id = data.get('building_id', None)
        try:
            People.objects.get(pk = id_name)
        except People.DoesNotExist:
            raise  ValidationError("The Person is not registered")
        b =Building.objects.filter(name= building_id)
        if len(b)!=1:
            raise ValidationError("The Building is not registered") 
        return data

class BuildingSerializer(ModelSerializer):
    class Meta:
        model = Building
        fields = ('id',  'name')
