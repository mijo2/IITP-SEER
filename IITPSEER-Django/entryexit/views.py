from django.shortcuts import render
from django.http import HttpResponse, JsonResponse
from django.views.decorators.csrf import csrf_exempt
from rest_framework.renderers import JSONRenderer
from rest_framework.parsers import JSONParser
from rest_framework.views import APIView
from rest_framework.parsers import MultiPartParser, FormParser  
from rest_framework.generics import ListAPIView
from django.contrib.auth.models import User, Group
from .models import EntryExit, Building
from people.models import People
from rest_framework import viewsets
from entryexit.serializers import EntryExitSerializer, BuildingSerializer
from rest_framework.response import Response
from django.http import Http404
from rest_framework import status
from rest_framework import permissions
from datetime import datetime

##############################################################################################
#           APIVIEW FOR BUILDING MODEL
##############################################################################################


class BuildingViewSet(viewsets.ModelViewSet):
    """
    API endpoint that allows groups to be viewed or edited.
    """
    queryset = Building.objects.all()
    serializer_class = BuildingSerializer

##############################################################################################

#           APIVIEW FOR ENTRYEXIT MODEL
##############################################################################################


# class EntriesList(APIView):

#     parser_classes = (MultiPartParser, JSONParser)
#     # permission_classes = (permissions.IsAuthenticatedOrReadOnly,)
#     @csrf_exempt
#     def get(self, request, *args, **kwargs):
#         entries = EntryExit.objects.all()
#         serializer = EntryExitSerializer(entries, many=True)
#         return Response(serializer.data)
#     @csrf_exempt
#     def post(self, request, *args, **kwargs):
#         serializer = EntryExitSerializer(data=request.data)
#         if serializer.is_valid():
#             serializer.save()
#             return  Response(request.data, status=status.HTTP_201_CREATED)
#         return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)


# class EntriesDetail(APIView):
#     """
#     Retrieve, update or delete a code peoples.
#     """
#     parser_classes = (MultiPartParser, JSONParser)
#     # permission_classes = (permissions.IsAuthenticatedOrReadOnly,)
#     @csrf_exempt
#     def get_object(self, pk):
#         try:
#             return EntryExit.objects.get(pk=pk)
#         except EntryExit.DoesNotExist:
#             raise Http404
#     @csrf_exempt
#     def get(self, request, pk, format=None):
#         people = self.get_object(pk)
#         serializer = EntryExitSerializer(people)
#         return Response(serializer.data)
#     @csrf_exempt
#     def put(self, request, pk, format=None):
#         people = self.get_object(pk)
#         serializer = EntryExitSerializer(people, data=request.data)
#         if serializer.is_valid():
#             serializer.save()
#             return Response(serializer.data)
#         return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

class EntryAPIView(APIView):
    parser_classes = [MultiPartParser, JSONParser]
    def get_object(self, request):
        id_name = request.data['id_name']
        building_id = request.data['building_id']
        entry = EntryExit.objects.filter(id_name=id_name,building_id=building_id,entrytimestamp=None)
        if len(entry)>=1:    
            return self.update_object(entry.first(), request)
        else:
            return self.create_object(request)

    def update_object(self, object, request):
        request.data['entrytimestamp'] = datetime.now()
        serializer = EntryExitSerializer(object,data =request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    
    def create_object(self,request):
        request.data['entrytimestamp'] = datetime.now()
        serializer = EntryExitSerializer(data =request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
        
    @csrf_exempt
    def post(self, request, format=None):
        return self.get_object(request)

class ExitAPIView(APIView):
    parser_classes = [MultiPartParser, JSONParser]
    def get_object(self, request):
        id_name = request.data['id_name']
        building_id = request.data['building_id']
        entry = EntryExit.objects.filter(id_name=id_name,building_id=building_id,exittimestamp=None)
        if len(entry)>=1:    
            return self.update_object(entry.first(), request)
        else:
            return self.create_object(request)

    def update_object(self, object, request):
        request.data['exittimestamp'] = datetime.now()
        serializer = EntryExitSerializer(object,data =request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    
    def create_object(self,request):
        request.data['exittimestamp'] = datetime.now()
        serializer = EntryExitSerializer(data =request.data)
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)
        
    @csrf_exempt
    def post(self, request, format=None):
        return self.get_object(request)



class EntryExitListAPIView(ListAPIView):
    parser_classes = [MultiPartParser, JSONParser]
    serializer_class = EntryExitSerializer
    queryset = EntryExit.objects.all()

##############################################################################################
#           END 
##############################################################################################
