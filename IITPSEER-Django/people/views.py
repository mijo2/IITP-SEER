from django.shortcuts import render
from django.http import HttpResponse, JsonResponse, Http404

from django.views.decorators.csrf import csrf_exempt

from rest_framework.renderers import JSONRenderer
from rest_framework.parsers import JSONParser
from rest_framework.parsers import MultiPartParser, FormParser
from rest_framework.generics import ListAPIView, RetrieveUpdateAPIView, CreateAPIView
from rest_framework.views import APIView
from rest_framework.viewsets import ModelViewSet
from rest_framework import status
from rest_framework.authtoken.models import Token
from rest_framework.decorators import api_view, permission_classes
from rest_framework.permissions import AllowAny
from rest_framework.response import Response
from rest_framework.status import (
    HTTP_400_BAD_REQUEST,
    HTTP_404_NOT_FOUND,
    HTTP_200_OK
)

from django.contrib.auth import authenticate
from django.contrib.auth.models import User, Group

from .models import People
from .serializers import UserSerializer, GroupSerializer, PeopleSerializer


#################################################################################
#           LOGIN VIEW
#################################################################################



@csrf_exempt
@api_view(["POST"])
@permission_classes((AllowAny,))
def login(request):
    username = request.data.get("username")
    password = request.data.get("password")
    if username is None or password is None:
        return Response({'error': 'Please provide both username and password'},
                        status=HTTP_400_BAD_REQUEST)
    user = authenticate(username=username, password=password)
    if not user:
        return Response({'error': 'Invalid Credentials'},
                        status=HTTP_404_NOT_FOUND)
    token, _ = Token.objects.get_or_create(user=user)
    return Response({'token': token.key},
                    status=HTTP_200_OK)

#################################################################################
#           API VIEWS FOR USER MODEL
#################################################################################

class UserViewSet(ModelViewSet):
    """
    API endpoint that allows users to be viewed or edited.
    """
    queryset = User.objects.all().order_by('-date_joined')
    serializer_class = UserSerializer

#################################################################################
#           API VIEWS FOR GROUP MODEL
#################################################################################

class GroupViewSet(ModelViewSet):
    """
    API endpoint that allows groups to be viewed or edited.
    """
    queryset = Group.objects.all()
    serializer_class = GroupSerializer

#################################################################################
#           API VIEWS FOR PEOPLE MODEL
#################################################################################

class  PeopleDetailAPIView(RetrieveUpdateAPIView):
    parser_classes = (MultiPartParser, JSONParser)
    queryset = People.objects.all()
    serializer_class = PeopleSerializer

class PeopleListAPIView(ListAPIView):
    parser_classes = (MultiPartParser, JSONParser)
    queryset = People.objects.all()
    serializer_class = PeopleSerializer

class PeopleCreateAPIView(CreateAPIView):
    parser_classes = (MultiPartParser, JSONParser)
    queryset = People.objects.all()
    serializer_class = PeopleSerializer


class PeopleDeleteAPIView(APIView):
    """
    Retrieve, update or delete a code peoples.
    """
    parser_classes = (MultiPartParser, JSONParser)
    
    @csrf_exempt
    def get_object(self, pk):
        try:
            return People.objects.raw('SELECT id from people_people where id regexp \'^'+pk+'\';')
        except People.DoesNotExist:
            raise Http404
    
    @csrf_exempt
    def get(self, request, pk, format=None):
        return Response("Invalid Request" , status=status.HTTP_400_BAD_REQUEST)

    
    @csrf_exempt
    def put(self, request, pk, format=None):
        return Response("Invalid Request" , status=status.HTTP_400_BAD_REQUEST)
    
    @csrf_exempt
    def delete(self, request, pk, format=None):
        peoples = self.get_object(pk)
        for people in peoples:
            try:
                people.delete()
            except People.DoesNotExist:
                raise Http404
            
        return Response(status=status.HTTP_204_NO_CONTENT)


#################################################################################
#           END
#################################################################################
