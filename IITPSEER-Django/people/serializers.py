from django.contrib.auth.models import User, Group
from rest_framework.serializers import (
    ModelSerializer,
    CharField,
    ImageField,
    EmailField,
    Serializer
)
from .models import People

class UserSerializer(ModelSerializer):
    class Meta:
        model = User
        fields = (
            'url', 
            'username', 
            'email', 
            'groups'
        )


class GroupSerializer(ModelSerializer):
    class Meta:
        model = Group
        fields = (
            'url', 
            'name'
        )


class PeopleSerializer(ModelSerializer):
    class Meta:
        model = People
        fields = (
            'id',
            'name',
            'phone',
            'photo',
            'email',
        )
        ordering = ['-id']



